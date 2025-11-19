import './bootstrap';
import { createApp } from 'vue';
import OrderMonitor from './components/OrderMonitor.vue';

const app = createApp({});
app.component('order-monitor', OrderMonitor);
app.mount('#app');
