<template>
    <div class="products-create">
        <h3>Produtos</h3>
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
</template>



<script>
    export default {
    name: 'productsCreate',
    data() {
        return {
            fields: {}
        }
    },
    methods: {
        submit() {
            axios.post('api/products', this.fields).then(response => {
                this.fields = {}
            }).catch(error => {
               alert(error.response.data)
            })
        }
    }
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
