<template>
    <div id="app">
        <div id="nav"><nav-menu/></div>
        <router-view/>
    </div>
</template>

<script>
import NavMenu from './components/NavMenu'

export default {
    components: {
        NavMenu
    }
}
</script>
