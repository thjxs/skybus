<template>
    <form class="form-signup" @submit.prevent="register">
        <div class="text-center mb-4">
            <h3 class="mb-3 font-weight-normal">Register</h3>
        </div>

        <div class="form-label-group">
            <input v-model="username" id="inputName" placeholder="User name" type="text" class="form-control" required autofocus>
            <label for="inputName">User name</label>
        </div>
        <div class="form-label-group">
            <input v-model="email" id="inputEmail" placeholder="Email address" type="email" class="form-control" required>
            <label for="inputEmail">Email address</label>
        </div>
        <div class="form-label-group">
            <input v-model="password" id="inputPassword" placeholder="Password" type="password" class="form-control" required>
            <label for="inputPassword">Password</label>
        </div>
        <div class="form-label-group">
            <input v-model="password_confirmation" id="inputPasswordConfirmation" type="password" placeholder="Confirm password" class="form-control" required>
            <label for="inputPasswordConfirmation">Confirm password</label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
    </form>
</template>

<script>
export default {
    data () {
        return {
            username: '',
            email: '',
            password: '',
            password_confirmation: ''
        }
    },

    methods: {
        register () {
            const payload = {
                username: this.username,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            }

            window.axios.post('/api/register', payload).then(response => {
                console.log(response)
            })
        }
    }
}
</script>
