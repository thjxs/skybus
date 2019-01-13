<template>
    <div class="container">
        <section class="navigation-container">
            <ul class="navigation-bar list-unstyled">
                <router-link to="categories" tag="li" title="categories">
                    <a>categories</a>
                </router-link>
                <router-link to="latest" tag="li" title="latest">
                    <a>latest</a>
                </router-link>
                <router-link to="top" tag="li" title="top">
                    <a>top</a>
                </router-link>
            </ul>
        </section>
        <div class="list-container">
            <div class="row">
                <div class="list-area">
                    <table class="thread-list">
                        <thead>
                            <tr>
                                <th class="title">Thread</th>
                                <th class="sortable" :class="{ sorting: sortableArray[0].isSorting }"@click="reloadThreadsWith(sortableArray[0])">Category</th>
                                <th class="posters">Users</th>
                                <th class="posts num sortable" :class="{ sorting: sortableArray[2].isSorting }" @click="reloadThreadsWith(sortableArray[2])">{{ sortableArray[2].name }}</th>
                                <th class="views num sortable" :class="{ sorting: sortableArray[1].isSorting }" @click="reloadThreadsWith(sortableArray[1])">{{ sortableArray[1].name }}</th>
                                <th class="activity sortable">Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <thread-list
                                v-for="thread in threads.data"
                                :key="thread.id"
                                :thread="thread"/>
                        </tbody>
                    </table>
                </div>
                <div class="container" v-if="isFetching">
                    <LoadingCircle/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ThreadList from '../components/ThreadList.vue'
import LoadingCircle from '../components/Circle.vue'

export default {
    name: 'home',
    components: {
        LoadingCircle,
        ThreadList
    },
    data () {
        return {
            isFetching: false,
            isAscending: false,
            sortableArray: [
                {"name": "node_id", "isSorting": false},
                {"name": "view", "isSorting": false},
                {"name": "reply", "isSorting": false}
            ],
            threads: {
                data: [],
                links: Object,
                meta: Object
            }
        }
    },
    created () {
        this.loadThreads()
        window.addEventListener('scroll', () => {
            if (this.shouldLoadThreads()) {
                if (this.isFetching) {
                    return
                } else {
                    this.isFetching = true
                }
                this.fetchThreads()
            }
        })
    },
    methods: {
        buildLoadThreadURL (order) {
            var url = `/api/threads?`
            if (order) {
                url = url.concat(`order=${order.name}`)
            }
            if (this.isAscending) {
                url = url.concat('&ascending=true')
            }
            return url
        },
        reloadThreadsWith (order) {
            this.sortableArray.forEach(sort => {
                sort.isSorting = (sort.name == order.name)
            })
            if (this.isAscending) {
                this.isAscending = false
            } else {
                this.isAscending = true
            }
            this.loadThreads(this.buildLoadThreadURL(order))
        },
        loadThreads (url = '/api/threads') {
            window.axios.get(url)
                .then(response => {
                    this.threads = response.data
                    this.isFetching = false
                })
        },
        fetchThreads () {
            window.axios.get(this.threads.links.next)
                .then(response => {
                    this.threads.data.push(...response.data.data)
                    this.threads.links = response.data.links
                    this.isFetching = false
                })
        },
        shouldLoadThreads () {
            if (this.threads.links.next === null) {
                return false
            }
            var max = document.body.scrollHeight - innerHeight
            return (pageYOffset / max) > 0.96 ? true : false
        }
    }
}
</script>

<style>
.container {
    width: 960px;
    margin: 0 auto;
}
.navigation-bar {
    display: flex;
}
.navigation-bar li {
    margin-right: 15px;
    padding: 5px;
}
.navigation-bar a {
    color: #212529;
}
.navigation-bar li:hover {
    background-color: #eee;
}
.navigation-bar li a:hover {
    text-decoration: none;
}
.thread-list {
    margin: 0 0 10px;
    width: 100%;
    border-collapse: collapse;
}
.thread-list .posters {
    width: 200px;
}
.thread-list .views {
    width: 60px;
}
.thread-list .title {
    width: 240px;
}
.thread-list .num {
    text-align: center;
}
.thread-list .sortable:hover {
    cursor: pointer;
    background-color: #e9e9e9;
}
.thread-list .sorting {
    background-color: #e9e9e9;
}
.thread-list th,
.thread-list td {
    padding: 12px 5px;
}
.thread-list thead tr {
    border-bottom: 3px solid #e9e9e9;
}
tr {
    border-bottom: 1px solid #e9e9e9;
}
</style>
