import './bootstrap';

import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import MemberManagement from './components/MemberManagement.vue';

const app = createApp({});

app.component('example-component', ExampleComponent);
app.component('login-component', LoginComponent);
app.component('member-management', MemberManagement);

app.mount('#app');
