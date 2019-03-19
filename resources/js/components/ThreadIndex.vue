<script>
    import axios from 'axios'
    import _ from 'lodash'
    import LoadingCircle from './LoadingCircle.vue'
    export default {
        props: [],
        components: {
            LoadingCircle
        },

        data() {
            return {
                order: '',
                ascending: false,
                threads: {
                    data: [],
                    links: Object,
                    meta: Object
                },
                ready: false,
                lastThreadIndex: '',
                hasNewThreads: false,
                loadingMoreThreads: false,
                loadingNewThreads: false,

                updateTimeAgoTimeout: null,

                newThreadsTimeout: null,
                newThreadsTimer: 2500,

                updateThreadsTimeout: null,
                updateThreadsTimer: 2500,
            }
        },

        mounted() {
            this.loadThreads((threads) => {
                this.threads = threads
                this.ready = true
            })
            // this.updateThreads()
            // this.updateTimeAgo()
            window.addEventListener('scroll', () => {
                if (this.shouldLoadOlderThreads()) {
                    if (this.loadingMoreThreads) {
                        return
                    } else {
                        this.loadingMoreThreads = true
                    }
                    this.loadOlderThreads()
                }
            })
        },

        destroyed() {
            clearTimeout(this.newThreadsTimeout)
            clearTimeout(this.updateThreadsTimeout)
            clearTimeout(this.updateTimeAgoTimeout)

            document.onkeyup = null;
        },

        watch: {

        },

        methods: {
            loadThreads(after) {
                axios.get('/api/threads' + '?order=' + this.order +
                    '&ascending=' + this.ascending
                ).then(response => {
                    if (_.isFunction(after)) {
                        after(response.data)
                    }
                })
            },

            checkForNewThreads() {
                this.newThreadsTimeout = setTimeout(() => {
                    axios.get('/api/threads' + '?order=' + this.order +
                        '&ascending' + this.ascending
                    ).then(response => {
                        if (response.data.length && !this.threads.length) {
                            this.loadingNewThreads()
                        } else if (response.data.length && _.first(response.data).id !== _.first(this.threads).id) {
                            this.hasNewThreads = true
                        } else {
                            this.checkForNewThreads()
                        }
                    })
                }, this.newThreadsTimer)
            },

            updateTimeAgo() {
                this.updateTimeAgoTimeout = setTimeout(() => {
                    _.each()
                })
            },

            shouldLoadOlderThreads () {
                if (this.threads.links.next === null) {
                    return false
                }
                var max = document.body.scrollHeight - innerHeight
                return (pageYOffset / max) > 0.96 ? true : false
            },

            loadOlderThreads () {
                this.loadingMoreThreads = true

                axios.get(this.threads.links.next).then(response => {
                    this.threads.data.push(...response.data.data)
                    this.threads.links = response.data.links
                    this.loadingMoreThreads = false
                })
            }
        }
    }
</script>
<template>
    <div class="container">
        <div class="row">
            <div class="list-area">
                <div class="d-flex" v-if="ready && threads.length ==0">
                    <span>empty</span>
                </div>
                <table class="thread-list">
                    <thead>
                    <slot name="table-header"></slot>
                    </thead>

                    <transition-group tag="tbody" name="list">
                        <tr v-if="hasNewThreads" key="newThreads">
                            <td class="text-center">
                                <small><a href="#" v-on:click.prevent="loadNewEntries" v-if="!loadingNewThreads">Load New Threads</a></small>
                                <small v-if="loadingNewThreads">
                                    <LoadingCircle/>
                                </small>
                            </td>
                        </tr>

                        <tr v-for="thread in threads.data" :key="thread.id">
                            <slot name="row" :thread="thread"></slot>
                        </tr>

                        <tr key="loadingCircle" v-if="loadingMoreThreads">
                            <td colspan="100">
                                <LoadingCircle/>
                            </td>
                        </tr>
                    </transition-group>
                </table>
            </div>
        </div>
    </div>
</template>
