<template>
	<view>
		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<view class="p0_30">
			<view class="search_box">
				<view class="box flex bor10 itc">
					<view class="iconsousuo fz40 c9 pl20 pr20"></view>
					<view class="flex_1">
						<input maxlength="-1"  type="text" class="w100 fz28 c3" placeholder="Enter one user name" v-model="searchStr" @confirm="confirm" />
					</view>
				</view>
			</view>
			<view class="h70"></view>
			<!--  -->
			<view>
				<mescroll-uni ref="mescrollRef" @init="mescrollInit" :fixed="true" :down="downOption"
					@down="downCallback" :up="upOption" @up="upCallback" @emptyclick="emptyClick" top="70rpx">
					<view class="p30">

						<view class="flex itc p20_0" v-for="(item,index) in list"
							@click="nav('/pages/userIndex/userIndex?id='+ item.ta_id)">
							<view class="avt">
								<!-- <image :src="url + item.followpic" mode=""></image> -->
								<img-cache :src="url + item.ta_avatar" :customStyle="customStyle" width="100rpx"
									height="100rpx" mode="aspectFill" bgSrc="../../static/images/loading1.png">
								</img-cache>
							</view>
							<view class="flex_1 mr20">
								<view class="oh1 fz30 c3">{{item.ta_nickname}}</view>
								<!-- <view class="oh1 fz26 c6">{{item.followsign}}</view> -->
							</view>
							<!-- 关注 -->
							<!-- <view class="follow_btn flex itc juc btn_bg">
								<view class="iconjia cf fz18 mr5"></view>
								<view class="fz28 cf">follow</view>
							</view> -->
							<!-- <view class="follow_btn flex itc juc " :class="{'btn_bg' : item.isfollow == 0}"
								@click.stop="followFn(index)">
								<view class="iconjia cf fz18 mr5" v-if="item.isfollow == 0"></view>
								<view class="fz28 cf">{{item.isfollow == 0 ? 'follow' : 'following'}}</view>
							</view> -->
						</view>

					</view>
				</mescroll-uni>
			</view>

		</view>
	</view>
</template>

<script>
	import MescrollMixin from "@/components/mescroll-uni/mescroll-mixins.js";
	export default {
		mixins: [MescrollMixin], // 注意此处还需使用MescrollMoreItemMixin (必须写在MescrollMixin后面)
		data() {
			return {
				param: {},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				downOption: {
					auto: true, // 不自动加载 (mixin已处理第一个tab触发downCallback)
					bgColor: "#48cfb2"
				},
				upOption: {
					auto: false, // 不自动加载
					page: {
						num: 0, // 当前页码,默认0,回调之前会加1,即callback(page)会从1开始
						size: 10 // 每页数据的数量
					},
					noMoreSize: 1, //如果列表已无数据,可设置列表的总数量要大于半页才显示无更多数据;避免列表数据过少(比如只有一条数据),显示无更多数据会不好看; 默认5
					empty: {
						icon: 'bgImg',
						tip: 'No List',
						top: '260rpx'
					}
				},
				searchStr: "", //搜索内容
				list: [], //列表数据
				customStyle: {
					borderRadius: '50%'
				}
			}
		},
		onLoad(option) {
			this.param = option;
			if (option.from) {
				uni.setNavigationBarTitle({
					title: option.from
				})
			};
		},
		methods: {
			// 搜索
			confirm() {
				this.mescroll.resetUpScroll();
			},
			//关注方法
			followFn(index) {
				var datas = {
					apipage: "userfollow",
					op: "follow",
					followid: this.list[index].followid,
					tokenstr: this.token
				};
				this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
					var _list = this.list;
					if (res.error == 0) {
						for (var i = 0; i < _list.length; i++) {
							// 同一个人
							if (_list[i].followid == this.list[index].followid) {
								if (_list[i].isfollow == 0) {
									_list[i].isfollow = 1;
								} else {
									_list[i].isfollow = 0;
								}
							}
						};
						console.log(_list)
						this.list = _list;
					} else {
						this.requestSet.showToast(res.returnstr);
					};
				}).catch((err) => {
					console.log(err)
				});
			},
			/*下拉刷新的回调 */
			downCallback() {
				// 这里加载你想下拉刷新的数据, 比如刷新轮播数据
				// loadSwiper();
				// 下拉刷新的回调,默认重置上拉加载列表为第一页 (自动执行 page.num=1, 再触发upCallback方法 )
				setTimeout(() => {
					this.mescroll.resetUpScroll()
				}, 500)
			},
			/*上拉加载的回调: 其中page.num:当前页 从1开始, page.size:每页数据条数,默认10 */
			upCallback(page) {
				// 判断页面区分请求参数
				var datas = {
					fans: this.param.from == 'Follow' ? 1 : 0, // ""
					page: page.num,
					limit: this.requestSet.pageSize,
					search: this.searchStr
				};
				this.requestSet.getData(datas, '/V1.MemberFollow/index', 'GET').then((res) => {
					if (res.status == 200) {
						this.mescroll.endSuccess(res.data.list.length);
						//如果是第一页需手动制空列表--并获取当前栏目广告内容
						if (page.num == 1) {
							this.list = [];
						};
						// for (var i = 0; i < res.list.length; i++) {
						// 	res.list[i].isfollow = 1;
						// };
						this.list = this.list.concat(res.data.list);
					} else {
						this.requestSet.showToast(res.msg);
					};
					this.isMark = false;
				}).catch((err) => {
					console.log(err)
					this.isMark = true;
					this.markType = 2;
					this.mescroll.endErr();
				});
			},
			emptyClick() {
				uni.showToast({
					title: '点击了按钮,具体逻辑自行实现'
				})
			},
			refresh(data) { //刷新当前页数据
				if (data == this.timestamp) {
					this.mescroll.resetUpScroll();
				}
			},
			nav(url) {
				uni.navigateTo({
					url: url
				})
			},

		}
	}
</script>

<style>
	.p20_0 {
		padding: 20rpx 0;
	}

	.search_box {
		background-color: #fff;
		height: 70rpx;
		position: fixed;
		width: 100%;
		z-index: 999;
		left: 0;
		padding: 0 30rpx;
		box-sizing: border-box;
	}

	.box {
		height: 70rpx;
		background: #f7f7f7;
	}

	.avt {
		width: 100rpx;
		height: 100rpx;
		overflow: hidden;
		margin-right: 36rpx;
	}

	.avt image {
		width: 100%;
		height: 100%;
		border-radius: 50%;
		display: block;
	}

	.follow_btn {
		width: 135rpx;
		height: 50rpx;
		border-radius: 25rpx;
		background-color: #dfdfdf;
	}

	.btn_bg {
		background: linear-gradient(to right, #48cfb0, #48d39d);
		/* background: -webkit-linear-gradient(top, #48cfb0 ,#48d39d ); */
	}
</style>
