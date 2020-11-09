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
                        <form class="form-inline" @submit.prevent="submit">
                            <div class="form-group">
                                <label for="client_id">cliente</label>
                                <select name="client_id" id="client_id" class="form-control ml-sm-2 mr-sm-4 my-2">
                                    <option v-for="client in clients">
                                        {{client.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_id">produto</label>
                                <select name="product_id" id="product_id" class="form-control ml-sm-2 mr-sm-4 my-2">
                                    <option v-for="product in products">
                                        {{product.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status_id">status</label>
                                <select name="status" id="status_id" class="form-control ml-sm-2 mr-sm-4 my-2">
                                    <option v-for="st in status">{{st.alias}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity_id">quantidade</label>
                                <input type="number" name="quantity" placeholder="quantidade" id="quantity_id"
                                       class="form-control ml-sm-2 mr-sm-4 my-2" required>
                            </div>
                            <div class="form-group">
                                <label>Valor total do pedido</label>
                                <input type="number" name="price" id="price_id" placeholder="Preço do produto"
                                       class="form-control ml-sm-2 mr-sm-4 my-2" required>
                            </div>
                            <div class="ml-auto text-right">
                                <button type="submit" class="btn btn-primary my-2">Adicionar</button>
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
                                    <td>{{ order.status }}</td>
                                    <td>{{ totalPrice(order.id)}}</td>
                                    <td>{{ formatDateTime(order.created_at) }}</td>
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
                {status: 'paid', alias: 'pago'},
                {status: 'pending', alias: 'pendente'},
                {status: 'canceled', alias: 'cancelado'},
            ],
            quantity: 0, //quantity of products
            baseUrl: 'api/orders/',

            editId: null,
            editData: {}
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
        totalPrice(order_id) {
            let sum = 0;
            const order = this.orders.find(obj => obj.id === order_id)
            order.oder_item.map((item) => {
                sum += item.price
            })
            return sum;
        },
        formatDateTime(date){
            const newDate = date.split("T")
            return newDate[0];
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
            this.orders = response[2]
            this.loading = false;
        }).catch(error => {
            console.log(error)
            alert("ops, ocorreu um erro. Tente novamente mais tarde!")
        });
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
