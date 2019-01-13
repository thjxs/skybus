<template>
    <form class="form-signin" @submit.prevent="login">
        <div class="text-center mb-4">
            <h3 class="mb-3 font-weigth-normal">Welcome</h3>
        </div>

        <div class="form-label-group">
            <input v-model="email" placeholder="Email address" type="email" id="inputEmail" class="form-control" required autofocus>
            <label for="inputEmail">Email address</label>
        </div>
        <div class="form-label-group">
            <input v-model="password" placeholder="Password" type="password" id="inputPassword" class="form-control" required>
            <label for="inputPassword">Password</label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</template>

<script>
export default {
    data () {
        return {
            email: '',
            password: ''
        }
    },

    methods: {
        login () {
            const payload = {
                email: this.email,
                password: this.password
            }

            window.axios.post('/login', payload).then(response => {
                console.log(response)
            })
        }
    }
}
</script>
