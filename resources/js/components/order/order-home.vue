<template>
    <div class="order-home">
        <div v-if="loading">
            <h3>Carregando...</h3>
        </div>
        <div class="container" v-else>
            <div class="card" style="margin-bottom: 25px">
                <div class="products-create">
                    <h3><i class="fa fa-shopping-cart" aria-hidden="true">&nbsp;</i>Produtos</h3>
                    <div class="card">
                        <div class="card-header">
                            Adicione um novo pedido
                        </div>
                        <div class="card-body">
                            <form class="form-inline" @submit.prevent="submit">
                                <div class="form-group" >
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
                                    <input type="number" name="quantity" placeholder="quantidade" id="quantity_id" class="form-control ml-sm-2 mr-sm-4 my-2" required>
                                </div>
                                <div class="form-group">
                                    <label>Valor total do pedido</label>
                                    <input type="number" name="price" id="price_id" placeholder="Preço do produto" class="form-control ml-sm-2 mr-sm-4 my-2" required>
                                </div>
                                <div class="ml-auto text-right">
                                    <button type="submit" class="btn btn-primary my-2">Adicionar</button>
                                </div>
                            </form>
                        </div>
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
        }
    },
    methods: {
        async loadClients() {
            return await axios.get('api/clients');
        },
        async loadProduts() {
            return await axios.get('api/clients');
        },
        async loadOrders() {
            return await axios.get(this.baseUrl);
        }
        // onDelete(id) {
        //     axios.delete(this.baseUrl + id).then(response => {
        //         this.loadClients()
        //         alert("cliente deletado")
        //     }).catch(error => {
        //         console.log(error.response.data)
        //     })
        // },
        // onEdit(client) {
        //     this.editId = client.id
        //     this.editClientData = client
        // },
        // onEditSubmit() {
        //     axios.patch(this.baseUrl + this.editId, this.editClientData).then(response => {
        //         this.onEditCancel()
        //         this.loadClients()
        //     }).catch(error => {
        //         console.log(error.response.data)
        //     })
        // },
        // onEditCancel() {
        //     this.editId = null
        //     this.editClientData = null
        // },
        // submit() {
        //     axios.post(this.baseUrl, this.fields).then(response => {
        //         this.loadClients()
        //     }).catch(error => {
        //         alert(error.response.data)
        //     })
        // },
    },
    mounted() {
        //waiting all promisses finish load
        Promise.all([
            this.loadClients(),
            this.loadProduts(),
            this.loadOrders()
        ]).then(response => {
            this.clients = response[0].data.data
            this.products = response[1].data.data
            this.orders = response[2].data.data
            this.loading = false;
        }).catch( error => {
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
