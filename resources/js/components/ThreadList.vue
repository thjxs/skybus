<template>
    <tr>
        <td class="thread-titel">{{ thread.title }}</td>
        <td>{{ thread.node_id }}</td>
        <td>{{ thread.user.name }}</td>
        <td class="num">{{ thread.cache.comments_count }}</td>
        <td class="num">{{ thread.cache.views_count }}</td>
        <td :title="thread.updated_at">{{ thread.updated_at | diffForHumans }}</td>
    </tr>
</template>

<script>
export default {
    name: 'TopicList',
    props: {
        thread: Object
    }
}
</script>
