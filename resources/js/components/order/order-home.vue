<template>
    <div class="order-home" v-if="!order_view">
        <div v-if="loading">
            <h3>Carregando...</h3>
        </div>
        <div class="container" v-else>
            <div class="card" style="margin-bottom: 25px">
                <h3><i class="fa fa-shopping-cart" aria-hidden="true">&nbsp;</i>Pedidos</h3>
                <div class="card">
                    <div class="card-header">
                        Adicione um novo pedido
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="row form-inline">
                                <div class="form-group col-md-4">
                                    <label for="client_id">cliente &nbsp;</label>
                                    <select name="client_id" id="client_id" class="form-control ml-sm-2 mr-sm-4 my-2" v-model="client_id">
                                        <option value="0" disabled>
                                            Selectione um cliente
                                        </option>
                                        <option v-for="client in clients" v-bind:value="client.id">
                                            {{client.name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="status_id">status &nbsp;</label>

                                    <select name="status" id="status_id" class="form-control ml-sm-2 mr-sm-4 my-2" v-model="client_status">
                                        <option v-for="st in status" v-bind:value="st.type">{{st.alias}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-secondary btn-block" @click="addInput">Adicionar produto +</button>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block">Salvar</button>
                                </div>
                            </div>
                            <div class="row form-inline" v-for="(input,k) in inputs" :key="k">
                                <div class="form-group col-md-4">
                                    <label for="product_id">produto &nbsp;</label>
                                    <select name="product_id" id="product_id" class="form-control ml-sm-2 mr-sm-4 my-2" v-model="input.product" v-on:change="calculateTotalPrice">
                                        <option value="0" disabled>
                                            Selectione seu produto
                                        </option>
                                        <option v-for="product in input.listProducts" v-bind:value="product.id">
                                            {{product.name}}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="quantity_id">quantidade &nbsp;</label>
                                    <select name="quantity" id="quantity_id" class="form-control ml-sm-4 mr-sm-4 my-2" v-model="input.quantaty" v-on:change="calculateTotalPrice">
                                        <option v-if="input.product === 0" value="0">
                                            0
                                        </option>
                                        <option v-else v-for="amount in searchAmountProduct(input.product)" v-bind:value="amount">
                                            {{amount}}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-secondary btn-block" @click="removeInput(input)">Remover produto - </button>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <p class="text-right mt-3 mr-5 mr-sm-3 font-weight-bold text-uppercase">total da compra: R$ {{this.totalPrice}}</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Lista de pedidos
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Cliente</th>
                                <th>Status</th>
                                <th>Preço total</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody v-for="order in orders" :key="order.id">
                            <tr>
                                <td>{{ order.id }}</td>
                                <td>{{ getClient(order.client_id)}}</td>
                                <td>{{ getStatus(order.status) }}</td>
                                <td>{{order.total_price}}</td>
                                <td>
                                    <a href="#" class="icon">
                                        <i class="fa fa-eye" aria-hidden="true" @click="onView(order)"></i>
                                    </a>
                                    <a href="#" class="icon">
                                        <i class="fa fa-trash" aria-hidden="true" @click="onDelete(order.id)"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <order-details
            :order="order_view"
            :client_name="order_client_name"
        />
    </div>
</template>

<script>
import OrderDetails from './order-details'
export default {
    name: "order-home",
    components: {
        OrderDetails
    },
    data() {
        return {
            loading: true,
            clients: null,
            products: null,
            orders: null,
            status: [
                {type: 'pending', alias: 'pendente'},
                {type: 'paid', alias: 'pago'},
                {type: 'canceled', alias: 'cancelado'},
            ],
            baseUrl: 'api/orders/',
            totalPrice: 0,
            editId: null,
            editData: {},
            inputs: [],
            client_id: 0,
            client_status: "pending",
            order_view: null,
            order_client_name: null
        }
    },
    methods: {
        async loadClients() {
            const {data} = await axios.get('api/clients');
            return data.data;
        },
        async loadProduts() {
            const {data} = await axios.get('api/products');
            return data.data;
        },
        async loadOrders() {
            const {data} = await axios.get('api/orders');
            return data.data;
        },
        async onDelete(id) {
            await axios.delete(this.baseUrl + id).then(response => {
                this.loadClients()
                alert("cliente deletado")
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        async onView(order){
            console.log(order)
            const {name} = this.clients.find(client => client.id === order.client_id)
            this.order_client_name = name
            this.order_view = order
        },
        async onEditCancel() {
            this.editId = null
            this.editClientData = null
        },
        async submit() {
            const order = {
                client_id: this.client_id,
                status: this.client_status,
                products: this.inputs
            }
            await axios.post(this.baseUrl, order).then(response => {
                this.loading = true
                this.client_id = 0
                this.inputs = []
                this.totalPrice = 0

                Promise.all([
                    this.loadClients(),
                    this.loadProduts(),
                    this.loadOrders()
                ]).then(response => {
                    this.clients = response[0]
                    this.products = response[1]
                    this.inputs.push({
                        product: 0,
                        quantaty: 0,
                        listProducts: _.cloneDeep(this.products)
                    })
                    this.orders = response[2]
                    this.loading = false
                }).catch(error => {
                    console.log(error)
                    alert("ops, ocorreu um erro. Tente novamente mais tarde!")
                })
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        getStatus(status) {
            const stats = this.status.find(obj => obj.type === status)
            return stats.alias
        },
        getClient(client_id){
            const client = this.clients.find(obj => obj.id === client_id)
            return client.name
        },
        //cria novo input
        addInput(){
            //get last input
            const lastInput = this.inputs[this.inputs.length - 1]
            //prevent create new coponent
            if(lastInput.listProducts.length === 1) {
                return;
            }
            if(lastInput.product === 0) {
                alert('selecione um produto')
                return;
            }
            this.inputs.push({
                product: 0,
                quantaty: 0,
                listProducts: this.filterProducts(lastInput.listProducts)
            })
        },
        //returns total price of all products
        calculateTotalPrice() {
            this.totalPrice = 0
            this.inputs.map((item) => {
                const product = this.products.find(obj => item.product === obj.id)
                if(item.quantaty > product.amount){
                    item.quantaty = product.amount
                }
                this.totalPrice += product.price * item.quantaty
            })
        },
        //removing created input
        removeInput(item){
            //get last input
            const lastInput = this.inputs[this.inputs.length - 1]
            //prevent create new coponent
            if(lastInput.listProducts.length === 1) {
                return;
            }

            this.inputs = this.inputs.filter(input => input !== item)
            this.calculateTotalPrice()

            if(item.product !== 0){
                const selectedProduct = this.products.find(product => product.id === item.product)
                lastInput.listProducts.push(selectedProduct)
            }
        },
        //returns not selected products
        filterProducts(listProducts){
            const newListProducts = _.cloneDeep(listProducts)
            this.inputs.map(item => {
                let filtered = newListProducts.find(obj => obj.id === item.product)
                if(typeof filtered ==='undefined'){
                    return newListProducts
                }
                newListProducts.splice(filtered, 1)
            })
            return newListProducts
        },
        searchAmountProduct(product_id){
            const {amount} = this.products.find(product => product.id === product_id)
            const amountList = []
            for(let i = amount; i >= 0; i--){
                amountList.push(i)
            }
            return amountList
        },
    },
    mounted() {
        //waiting all promisses finish load
        Promise.all([
            this.loadClients(),
            this.loadProduts(),
            this.loadOrders()
        ]).then(response => {
            this.clients = response[0]
            this.products = response[1]
            this.inputs.push({
                product: 0,
                quantaty: 0,
                listProducts: _.cloneDeep(this.products)
            })
            this.orders = response[2]
            this.loading = false
        }).catch(error => {
            console.log(error)
            alert("ops, ocorreu um erro. Tente novamente mais tarde!")
        })
    },
}
</script>

<style scoped>
h3 {
    text-align: center;
    margin-top: 30px;
    margin-bottom: 20px;
}

.icon i {
    cursor: pointer;
}
</style>
