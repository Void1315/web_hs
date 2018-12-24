
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import ElementUI from 'element-ui';
import axios from 'axios';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(VueRouter)
Vue.use(ElementUI);
Vue.prototype.$axios = axios;
import Index from './components/Example.vue'
import Frame from './components/Frame.vue'
import User from './components/User.vue'
import CardFrom from './components/CardFrom.vue'
import CardSet from './components/CardSet.vue'
import UserManage from './components/UserManage.vue'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const router = new VueRouter({
  routes: [
    // 动态路径参数 以冒号开头
    { path: '/', component: Frame,
    	children:[
	    	{
	    		path: '',
      		component: Index
	    	},
        {
          path:'/user',
          component: User
        },
        {
          path:'/card',
          component : CardFrom
        },
        {
          path:'/cardset',
          component : CardSet
        },
        {
          path:'/usermanage',
          component : UserManage
        }
    	] 
    }
  ]
})
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
Vue.prototype.$token = token.content;
Vue.prototype.$auth = false;


router.beforeEach(function (to, from, next) {
    const nextRoute = [ '/', '/user', '/card','/cardset'];

    if (nextRoute.indexOf(to.path) >= 0) {
        //未登录
        console.log()
        if(getCookie("islogin")=="true"){
            next();
          }else{
            window.location.href = '/loginUser'
            // router.push('./loginUser')
          }
    }
    next();
});
function getCookie(name) 
{ 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
 
    if(arr=document.cookie.match(reg))
 
        return unescape(arr[2]); 
    else 
        return null; 
};

const app = new Vue({
    el: '#app',
    router
});
