import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
const store = new Vuex.Store({
	state: { //数据表
		userInfo: uni.getStorageSync('userInfo') || "",
		token: "", // 用户token
		fromCenter: false, //是否是个人中心进入
		searchInfo:{},
		qaClassList:[],//qa分类列表
		alarmLists:[] ,// 已设置提醒列表
		reStatus: {} //推荐栏目开关状态
	},
	mutations: { //vuex只能通过mutations方法更新数据表，组建中使用this.$store.commit('mutations中方法名称','传递的数据')
		setUserInfo(state, provider) { //用户信息
			state.userInfo = provider;
		},
		setToken(state, provider) { //token
			state.token = provider;
		},
		setFromCenter(state, provider) { //是否是个人中心进入
			state.fromCenter = provider;
		},
		setSearchInfo(state, provider) { //识别结果数据
			state.searchInfo = provider;
		},
		setQqaClassList(state, provider) { //qa分类列表
			state.qaClassList = provider;
		},
		setAlarmList(state, provider) { //qa分类列表
			state.alarmLists = provider;
		},
		setReStatus(state, provider) { //qa分类列表
			state.reStatus = provider;
		},
	},
	getters: { // Getter 接受 state 作为其第一个参数; Getter 也可以接受其他 getter 作为第二个参数：
		// 可以把getters理解成页面中的computed
		getToken(state) { //获取token
			return state.userInfo.token;
		}
	}
});
store.subscribe(function(mutations, state) { // 监听state的数据变化
	//使用...运算符 过滤掉不可枚举的值
	if (mutations.type == 'setUserInfo') {
		uni.setStorageSync('userInfo', mutations.payload);
	}
	if (mutations.type == 'setSign') {
		uni.setStorageSync('sign', mutations.payload);
	}
})

//引用方法
// import {
// 		mapState, //获取vuex中的数据
// 		mapGetters, //获取Getters中的数据
// 		mapMutations //获取提交数据方法
// 	} from 'vuex';

//页面取值
// computed: {
// 			...mapState(['userInfo']),
// 			...mapGetters(['getToken'])
// 		},

//页面方法
// methods: {
// 	...mapMutations(['setUserInfo']),
// }
export default store;
