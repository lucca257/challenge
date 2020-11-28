<template>
    <div class="order-home">
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
                                    <select name="client_id" id="client_id" class="form-control ml-sm-2 mr-sm-4 my-2">
                                        <option v-for="client in clients">
                                            {{client.name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="status_id">status &nbsp;</label>
                                    <select name="status" id="status_id" class="form-control ml-sm-2 mr-sm-4 my-2">
                                        <option v-for="st in status">{{st.alias}}</option>
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
                                        <option v-for="product in input.listProducts"
                                                v-bind:value="product.id">
                                            {{product.name}}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="quantity_id">quantidade &nbsp;</label>
                                    <select name="quantity" id="quantity_id" class="form-control ml-sm-4 mr-sm-4 my-2" v-model="input.quantaty" v-on:change="calculateTotalPrice">
                                        <option value="0" disabled>
                                            0
                                        </option>
                                        <option value="1">
                                            1
                                        </option>
                                        <option value="2" >
                                            2
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-secondary btn-block" @click="removeInput">Remover produto - </button>
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
                                <th>Data</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody v-for="order in orders">
                            <tr>
                                <template v-if="editId == order.id">
                                    <td><input v-model="editData.name" type="text"></td>
                                    <td><input v-model="editData.price" type="number" min="0" step="0.01"
                                               data-number-to-fixed="2" data-number-stepfactor="100" placeholder="0.00">
                                    </td>
                                    <td><input v-model="editData.description" type="text"></td>
                                    <td>
                                    <span class="icon" @click="onEditSubmit()">
                                      <i class="fa fa-check"></i>
                                    </span>
                                        <span class="icon" @click="onEditCancel()">
                                      <i class="fa fa-ban"></i>
                                    </span>
                                    </td>
                                </template>
                                <template v-else>
                                    <td>{{ order.id }}</td>
                                    <td>{{ getClient(order.client_id)}}</td>
                                    <td>{{ getStatus(order.status) }}</td>
                                    <td>{{ totalPrice(order.id)}}</td>
                                    <td>
                                        <a href="#" class="icon">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" class="icon">
                                            <i class="fa fa-pencil" aria-hidden="true" @click="onEdit(order)"></i>
                                        </a>
                                        <a href="#" class="icon">
                                            <i class="fa fa-trash" aria-hidden="true" @click="onDelete(order.id)"></i>
                                        </a>
                                    </td>
                                </template>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "order-home",
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
        }
    },
    methods: {
        async loadClients() {
            const response = await axios.get('api/clients');
            return response.data.data;
        },
        async loadProduts() {
            const response = await axios.get('api/products');
            return response.data.data;
        },
        async loadOrders() {
            const response = await axios.get(this.baseUrl);
            return response.data.data;
        },
        async onDelete(id) {
            await axios.delete(this.baseUrl + id).then(response => {
                this.loadClients()
                alert("cliente deletado")
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        async onEdit(client) {
            this.editId = client.id
            this.editClientData = client
        },
        async onEditSubmit() {
            await axios.patch(this.baseUrl + this.editId, this.editClientData).then(response => {
                this.onEditCancel()
                this.loadClients()
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        async onEditCancel() {
            this.editId = null
            this.editClientData = null
        },
        async submit() {
            await axios.post(this.baseUrl, this.fields).then(response => {
                this.loadClients()
            }).catch(error => {
                alert(error.response.data)
            })
        },
        formatDateTime(date){
            const newDate = date.split("T")
            return newDate[0]
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
            this.inputs.push({
                product: 0,
                quantaty: 0,
                listProducts: this.filterProducts(lastInput.listProducts)
            })
        },
        //returns total price of all products
        calculateTotalPrice() {
            this.totalPrice = 0
            const selectedProducts = this.inputs.map((item) => {
                let product = this.products.find(obj => item.product === obj.id)
                this.totalPrice += product.price * item.quantaty
            })
        },
        //removing created input
        removeInput(item){
            this.inputs.splice(item, 1)
            this.calculateTotalPrice()
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
        }
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
