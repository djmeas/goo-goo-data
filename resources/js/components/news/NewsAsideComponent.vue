<template>
  <div id="blog-aside">
    <div class="container-posts bg-mat-tertiary">
        <h1>Latest News</h1>
        <div class="mt-4">
            <div v-for="(post, index) in posts" class="post" :key="'post' + index">
                <h3>{{post.header}}</h3>
                <p><i>Posted on {{post.date}} by {{post.author}}</i></p>
                <div v-html="post.body">
                    
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import blogPosts from '../../blogPosts.json';

export default {
    data() {
        return {
            posts: blogPosts
        }
    },
    created() {
        
    }
}
</script>

<style>

</style>