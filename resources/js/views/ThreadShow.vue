<template>
    <div class="container">
        <div class="thread-title">
            <h1>{{ thread.title }}</h1>
        </div>
        <div class="thread-container">
            <section class="thread-area">
                <div class="thread-owner">
                    <article
                        :data-thread-id="thread.id"
                        :data-thread-user-id="thread.user_id"
                        class="boxed">
                        <div class="row">
                            <div class="thread-avatar"></div>
                            <div class="thread-body">
                                <div class="thread-meta-data">
                                    <div class="trigger-user-card">
                                        <span class="username">
                                            <a>{{ thread.user.name }}</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="contents">
                                    <div class="cooked" v-html="thread.content.body"></div>
                                    <section class="thread-menu-area">
                                        <nav class="thread-controls">
                                            <button title="like"><i class="icon"></i></button>
                                            <button title="share"><i class="icon"></i></button>
                                        </nav>
                                    </section>
                                </div>
                                <div class="thread-map">
                                    <ul class="list-unstyled">
                                        <li>
                                            <h4>Created</h4>
                                            <div class="created-at">
                                                <a><img :src="thread.user.avatar"></a>
                                                <span
                                                    :title="thread.created_at"
                                                    data-format="tiny"
                                                >
                                                    {{ thread.created_at | diffForHumans }}
                                                </span>
                                            </div>
                                        </li>
                                        <li>
                                            <h4>Last Reply</h4>
                                            <div class="last-reply">
                                                <a><img :src="thread.user.avatar"></a>
                                                <span>{{ thread.updated_at | diffForHumans }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <span>{{ thread.cache.comments_count }}</span>
                                            <span>Comments</span>
                                        </li>
                                        <li>
                                            <span>{{ thread.cache.views_count }}</span>
                                            <span>Views</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </div>
</template>
