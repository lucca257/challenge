<template>
    <div class="products">
        <div class="card">
            <ProductCreate></ProductCreate>
        </div>
        <br>
        <div class="card">
            <ProductList></ProductList>
        </div>
        <div class="card">
        </div>
    </div>
</template>

<script>
export default {
    name: 'Products-page',
    components: {
        ProductList: () => import('./list'),
        ProductEdit: () => import('./edit'),
        ProductCreate: () => import('./create')
    },
    methods: {
        reloadList() {
        }
    }
}
</script>
