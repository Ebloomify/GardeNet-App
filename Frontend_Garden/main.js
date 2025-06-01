import Vue from 'vue';
import App from './App';
import store from './store';
import requestSet from 'common/common.js';
import $r from 'common/common.js';
//引用全局组件
import markLayer from '@/components/markLayer/markLayer';
//注册全局组件
Vue.component("markLayer", markLayer);
//配置全局变量-请求类
// 引入全局uView
import uView from 'uview-ui'
Vue.use(uView)
Vue.prototype.requestSet = requestSet;
Vue.prototype.$r = $r;
Vue.config.productionTip = false;
App.mpType = 'app';

// vuex全局引用
import {
	mapState, //获取vuex中的数据
	mapGetters, //获取Getters中的数据
	mapMutations //获取提交数据方法
} from 'vuex';
import mixins from '@/store/mixins.js';
Vue.mixin({
	computed: {
		...mapState([...mixins.mapState])
	},
	methods: {
		...mapMutations([...mixins.mapMutations]),
	}
});

// 在main.js注册全局组件 注册mescroll
import MescrollBody from "@/components/mescroll-uni/mescroll-body.vue"
import MescrollUni from "@/components/mescroll-uni/mescroll-uni.vue"
Vue.component('mescroll-body', MescrollBody)
Vue.component('mescroll-uni', MescrollUni)

const app = new Vue({
	...App,
	store
});
app.$mount();
