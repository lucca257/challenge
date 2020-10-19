<template>
    <div class="product-list">
        <div class="card" style="margin-bottom: 25px">
            <div class="products-create">
                <h3><i class="fa fa-shopping-cart" aria-hidden="true">&nbsp;</i>Produtos</h3>
                <div class="card">
                    <div class="card-header">
                        Adicione um novo Produto
                    </div>
                    <div class="card-body">
                        <form class="form-inline" @submit.prevent="submit">
                            <div class="form-group">
                                <label>Nome</label>
                                <input v-model="fields.name" type="text" class="form-control ml-sm-2 mr-sm-4 my-2" required>
                            </div>
                            <div class="form-group">
                                <label>Preço</label>
                                <input v-model="fields.price" type="number" value="0" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control ml-sm-2 mr-sm-4 my-2" required>
                            </div>
                            <div class="form-group">
                                <label>Descrição</label>
                                <input v-model="fields.description" type="text" class="form-control ml-sm-2 mr-sm-4 my-2">
                            </div>
                            <div class="ml-auto text-right">
                                <button type="submit" class="btn btn-primary my-2">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Lista de produtos
            </div>
            <div class="card-body">
                <div class="table-responsive" v-if="loading">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nome do produto</th>
                            <th>Preço</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody v-for="product in products">
                        <tr>
                            <template v-if="editId == product.id">
                                <td><input v-model="editProductData.name" type="text"></td>
                                <td><input v-model="editProductData.price" type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" required></td>
                                <td><input v-model="editProductData.description" type="text"></td>
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
                                <td>{{ product.name }}</td>
                                <td>{{ product.price }}</td>
                                <td>{{ product.description }}</td>
                                <td>
                                    <a href="#" class="icon">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" class="icon">
                                        <i class="fa fa-pencil" aria-hidden="true" @click="onEdit(product)"></i>
                                    </a>
                                    <a href="#" class="icon">
                                        <i class="fa fa-trash" aria-hidden="true" @click="onDelete(product.id)"></i>
                                    </a>
                                </td>
                            </template>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <h3>Carregando...</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "product-list",
    data() {
        return {
            products: null,
            loading: false,
            editId: null,
            baseUrl: 'api/products/',

            editProductData: {
                id: null,
                name: null,
                price: null,
                description: null,
            },

            fields: {}
        }
    },
    mounted() {
        this.loadProducts()
    },
    methods: {
        loadProducts() {
            axios.get(this.baseUrl, this.fields).then(response => {
                this.products = response.data
                this.loading = true
            }).catch(error => {
                console.log(error)
            })
        },
        onDelete(id) {
            axios.delete(this.baseUrl + id).then(response => {
                this.loadProducts()
                alert("produto deletado")
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        onEdit(product) {
            this.editId = product.id
            this.editProductData.name = product.name
            this.editProductData.price = product.price
            this.editProductData.description = product.description
            this.editProductData.id = this.editId
        },
        onEditSubmit() {
            axios.patch(this.baseUrl + this.editId, this.editProductData).then(response => {
                this.onEditCancel()
                this.loadProducts()
            }).catch(error => {
                console.log(error)
            })
        },
        onEditCancel() {
            this.editId = null
            this.editProductData.name = null
            this.editProductData.price = null
            this.editProductData.id = this.editId
        },
        submit() {
            axios.post('api/products', this.fields).then(response => {
                this.loadProducts()
            }).catch(error => {
                alert(error.response.data)
            })
        },
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
