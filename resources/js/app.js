import './bootstrap';
import { createApp } from 'vue';

import Article from './components/Article.vue';

const app = createApp({
    components: {
        'article-component': Article,
    }
}).mount('#app');