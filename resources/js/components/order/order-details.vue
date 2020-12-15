<template>
  <div class="order-details">
    <div class="card" style="margin-bottom: 25px">
      <h3>
        <i class="fa fa-shopping-cart" aria-hidden="true">&nbsp;</i>Detalhes do
        pedido {{ order.id }}
      </h3>
      <div class="card-header">
        <button>Voltar</button>
      </div>
      <div class="card-body">
        <form class="form-inline" @submit.prevent="submit">
          <div class="form-group">
            <label>Nome</label>
            <input
              type="text"
              class="form-control ml-sm-2 mr-sm-4 my-2"
              placeholder="nome do cliente"
              value="pedro teste"
              disabled
            />
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="" id="" class="form-control ml-sm-2 mr-sm-4 my-2">
              <option value="">exemplo</option>
              <option value="">exemplo</option>
              <option value="">exemplo</option>
            </select>
          </div>
          <div class="ml-auto text-right">
            <button type="submit" class="btn btn-primary my-2">
              Alterar Status
            </button>
          </div>
        </form>
      </div>
    </div>
    <div class="card" style="margin-bottom: 25px">
      <div class="card-header">Lista de itens</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>produto</th>
                <th>quantidade</th>
                <th>Preço total</th>
              </tr>
            </thead>
            <tbody v-for="item in order.oder_item" :key="order.id">
              <th>produto</th>
              <td>{{ item.quantity }}</td>
              <td>{{ item.price }}</td>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "order-details",
  props: {
    order: {
      type: Object,
    },
  },
};
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
