<template>
    <div class="container">
        <section class="navigation-container">
            <ul class="navigation-bar list-unstyled d-flex">
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
        <thread-index>
            <tr slot="table-header">
                <th>Thread</th>
                <th>Category</th>
                <th>Users</th>
                <th>Comments</th>
                <th>Views</th>
                <th>Activity</th>
            </tr>

            <template slot="row" slot-scope="slotProps">
                <td class="thread-title">
                    <router-link :to="{name: 'thread', params: {id: slotProps.thread.id}}">
                        {{ slotProps.thread.title }}
                    </router-link>
                </td>
                <td>{{ slotProps.thread.node_id }}</td>
                <td>{{ slotProps.thread.user.name }}</td>
                <td>{{ slotProps.thread.cache.comments_count }}</td>
                <td>{{ slotProps.thread.cache.views_count }}</td>
                <td>{{ slotProps.thread.updated_at | diffForHumans }}</td>
            </template>
        </thread-index>
    </div>
</template>

<script>
export default {
    name: 'home',
}
</script>
