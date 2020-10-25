<template>
    <div class="order-home">
        <div class="card" style="margin-bottom: 25px">
            <div class="clients-create">
                <h3><i class="fa fa-users" aria-hidden="true">&nbsp;</i>Clientes</h3>
                <div class="card">
                    <div class="card-header">
                        Adicione um novo pedido
                    </div>
                    <div class="card-body">
                        <form class="form-inline" @submit.prevent="submit">
                            <div class="form-group">
                                <label>Nome</label>
                                <input v-model="fields.name" type="text" class="form-control ml-sm-2 mr-sm-4 my-2" placeholder="nome do cliente" required>
                            </div>
                            <div class="form-group">
                                <label>email</label>
                                <input v-model="fields.email" type="email" name="email" placeholder="Email do cliente" class="form-control ml-sm-2 mr-sm-4 my-2" required>
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
                Lista de Clientes
            </div>
            <div class="card-body">
                <div class="table-responsive" v-if="loading">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody v-for="client in clients">
                        <tr>
                            <template v-if="editId == client.id">
                                <td><input v-model="editClientData.name" type="text" style="width: 100%;"></td>
                                <td><input v-model="editClientData.email" type="email" style="width: 100%;"></td>
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
                                <td>{{client.name}}</td>
                                <td>{{client.email}}</td>
                                <td>
                                    <a href="#" class="icon">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a href="#" class="icon">
                                        <i class="fa fa-pencil" aria-hidden="true" @click="onEdit(client)"></i>
                                    </a>
                                    <a href="#" class="icon">
                                        <i class="fa fa-trash" aria-hidden="true" @click="onDelete(client.id)"></i>
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
    name: "order-home",
    data() {
        return {
            clients: null,
            loading: false,
            editId: null,
            baseUrl: 'api/clients/',

            editClientData: {},
            fields: {}
        }
    },
    mounted() {
        this.loadClients()
    },
    methods: {
        loadClients() {
            axios.get(this.baseUrl, this.fields).then(response => {
                this.clients = response.data.data
                this.loading = true
            }).catch(error => {
                console.log(error)
            })
        },
        onDelete(id) {
            axios.delete(this.baseUrl + id).then(response => {
                this.loadClients()
                alert("cliente deletado")
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        onEdit(client) {
            this.editId = client.id
            this.editClientData = client
        },
        onEditSubmit() {
            axios.patch(this.baseUrl + this.editId, this.editClientData).then(response => {
                this.onEditCancel()
                this.loadClients()
            }).catch(error => {
                console.log(error.response.data)
            })
        },
        onEditCancel() {
            this.editId = null
            this.editClientData = null
        },
        submit() {
            axios.post(this.baseUrl, this.fields).then(response => {
                this.loadClients()
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
