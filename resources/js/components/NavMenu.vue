<template>
    <nav class="navbar navbar-light">
        <router-link to="/" class="navbar-brand">Sky Bus</router-link>

        <div class="navbar-collapse">
            <form @submit.prevent="search" class="form-search">
                <input v-model="query" type="search" placeholder="Search" aria-label="Search">
                <button class="btn" type="submit">Search</button>
            </form>
        </div>
    </nav>
</template>

<script>
export default {
    data () {
        return {
            query: ''
        }
    },
    methods: {
        search () {
            const { href } = this.$router.resolve({
                name: 'search',
                query: {
                    query: this.query
                }
            })
            window.open(href, '_blank')
        }
    }
}
</script>
