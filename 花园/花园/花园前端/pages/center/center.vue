<template>
	<view>
		<!-- <view class="">
			<u-parse :html="str"></u-parse>
		</view> -->
		<view class="p0_30">
			<!-- 已登录状态 -->
			<view class="top_box flex itc" v-if="userInfo.data && userInfo.data.avatar && userInfo.token">
				<view class="mr40" @click="nav('/pages/center/userInfo/userInfo')">
					<!-- <image :src="url + userInfo.member.HeadPicUrl" mode="" class="avt"></image> -->
					<img-cache :customStyle="customStyleAvt" :src="$r.imgUrl+userInfo.data.avatar" width="122rpx"
						height="122rpx" mode="aspectFill" bgSrc="../../static/images/loading1.png"></img-cache>
				</view>
				<view class="flex_1 mr40" @click="nav('/pages/center/userInfo/userInfo')">
					<view class="fz40 c3 oh1 mb20" style="width: 400rpx; display: block;">{{userInfo.data.nickname}}</view>
					<view class="flex itc" @click.stop="nav('/pages/center/integral/integral')">
						<image :src="`../../static/images/l${userInfo.data.member_level}.png`" mode="widthFix"
							:class="'l'+userInfo.data.member_level" class="mr10"></image>
						<view class="fz24 c9">Available Rewards：<text class="ca fz30">{{userInfo.data.integral}}</text>
						</view>
					</view>

				</view>
				<view class="iconshezhi fz50 c6" @click="nav('/pages/center/set/set')"></view>
			</view>
			<!-- 未登录状态 -->
			<view class="" v-else>
				<view class="h40"></view>
				<u-button :hair-line="false" :ripple="true" :custom-style="customStyle" @click="btnLogin">Login
				</u-button>
			</view>
			<view class="h50"></view>
			<!--  -->
			<view class="bgf bor10" v-if="userInfo.data && userInfo.data.avatar && userInfo.token">
				<view class="flex juc itc p20_0">
					<!-- 我的点赞数量 -->
					<!-- <view class="flex_1 tac">
						<view class="fz34 c3 mb10">0</view>
						<view class="fz26 c9">Likes</view>
					</view> -->
					<view class="flex_1 tac" @click="nav('/pages/center/follow/follow?from=Follow')">
						<view class="fz34 c3 mb10 top_num" v-if="userInfo.token">{{userInfo.data.follows}}</view>
						<view class="fz34 c3 mb10 top_num" v-else>0</view>
						<view class="fz26 c9">Following</view>
						<!-- 我的关注数量 -->
					</view>
					<view class="flex_1 tac" @click="nav('/pages/center/follow/follow?from=Fans')">
						<view class="fz34 c3 mb10 top_num" v-if="userInfo.token">{{userInfo.data.fans}}</view>
						<view class="fz34 c3 mb10 top_num" v-else>0</view>
						<view class="fz26 c9">Followers</view>
						<!-- 我的粉丝数量 -->
					</view>
					<view class="flex_1 tac" @click="nav('/pages/center/notification/notification')">
						<view class="fz34 c3 mb10 top_num icondanseyuandian red" v-if="newUserInfo.notification_num > 0">{{newUserInfo.notification_num}}</view>
						<view class="fz34 c3 mb10 top_num " v-else >0</view>
						<view class="fz26 c9">Notification</view>
						<!-- 消息通知数量 replynum-->
					</view>
				</view>
			</view>
			<view class="bgf bor10" v-else>
				<view class="flex juc itc p20_0">
					<view class="flex_1 tac">
						<view class="fz34 c3 mb10 top_num">0</view>
						<view class="fz26 c9">Following</view>
						<!-- 我的关注数量 -->
					</view>
					<view class="flex_1 tac">
						<view class="fz34 c3 mb10 top_num">0</view>
						<view class="fz26 c9">Followers</view>
						<!-- 我的粉丝数量 -->
					</view>
					<view class="flex_1 tac">
						<view class="fz34 c3 mb10 top_num icondanseyuandian ">0</view>
						<view class="fz26 c9">Notification</view>
						<!-- 消息通知数量 replynum-->
					</view>
				</view>
			</view>
			<view class="h30"></view>
			<!--  -->

			<!--  -->
			<!--  -->
			<view class="bgf bor10" v-if="userInfo.data && newUserInfo.garden && userInfo.token">
				<view class="flex itc" @click="nav('/pages/center/garden/garden')">
					<view class="fz32 c3 lh80 flex_1" style="text-indent: 30rpx;">My Plants</view>
					<view class="fz20 c3">{{newUserInfo.garden.length || 0}} plant in total</view>
					<view class="iconarrow-right-copy-copy  c9"></view>
				</view>
				<!-- 设置花园是否可以查看 -->
				<view class="flex itc  h110 pl30 mb20 mr10">
					<view class="flex_1">
						<view class="fz24 c9">Make My Garden Public</view>
					</view>
					<view class="fz28 c9">
						<u-switch v-model="checked" size="40" active-color="#48cfb2" @change="change"></u-switch>
					</view>
				</view>
				<!-- 植物列表 -->
				<view class="flex flex_warp">
					<view class="botany_list" @click="gardenInfo(item)" v-for="(item,index) in newUserInfo.garden"
						v-if="index < 3">
						<view class="box">
							<!-- <image :src="url + getPic(item.pics)[0]" mode="aspectFill" v-if="getPic(item.pics)[0]"></image> -->
							<img-cache :customStyle="customStyleImg"
								:src="url + getPic(item.img)[0]" width="130rpx" height="130rpx" mode="aspectFill"
								bgSrc="../../static/images/loading1.png"></img-cache>
							<view class="tac fz26 c3 lh60 oh1">{{item.plant_name}}</view>
						</view>
					</view>
					<!-- add -->
					<view class="botany_list" @click="nav('/pages/center/garden/add')">
						<view class="add_btn">
							<view class="iconjia fz50 " style="color: #bebfc3;"></view>
						</view>
						<view class="tac fz26 c3 lh60 oh1">add</view>
					</view>
				</view>
			</view>
			<!--  -->
			<view class="h30"></view>
			<!--  -->
			<view class="bgf bor10">
				<view class="fz32 c3 lh80 " style="text-indent: 30rpx;">My Resources</view>
				<view class="flex flex_warp">
					<!-- 我的收藏 -->
					<view class="center_list" @click="nav('/pages/center/collection/collection')">
						<image src="../../static/images/c_03.jpg" mode=""></image>
						<view class="tac fz26 c3">Collection</view>
					</view>
					<!-- 我的积分 -->
					<view class="center_list" @click.stop="nav('/pages/center/integral/integral')">
						<image src="../../static/images/c_05.jpg" mode=""></image>
						<view class="tac fz26 c3">Rewards</view>
					</view>
					<!-- 我的bbs -->
					<view class="center_list" @click="nav('/pages/center/bbs/bbs')">
						<image src="../../static/images/c_14.jpg" mode=""></image>
						<view class="tac fz26 c3">Communitv Post</view>
					</view>
					<!-- 我的qa -->
					<view class="center_list" @click="nav('/pages/center/qa/qa')">
						<image src="../../static/images/c_12.jpg" mode=""></image>
						<view class="tac fz26 c3">Q & A</view>
					</view>
					<!-- 我的分享 -->
					<view class="center_list" @click="nav('/pages/center/share/share')">
						<image src="../../static/images/c_07.jpg" mode=""></image>
						<view class="tac fz26 c3">Share</view>
					</view>
					<!-- 花园代办事项 -->
					<!-- <view class="center_list" @click="nav('/pages/center/schedule/schedule')">
						<image src="../../static/images/c_13.jpg" mode=""></image>
						<view class="tac fz26 c3">Garden schedule</view>
					</view> -->
					<!-- 花园设置 -->
					<!-- <view class="center_list" @click="nav('/pages/center/set/set')">
						<image src="../../static/images/c_19.jpg" mode=""></image>
						<view class="tac fz26 c3">General</view>
					</view> -->
					<!-- 商城 -->
					<!-- <view class="center_list" @click="nav('/pages/webView/webView?shopType=1')"> -->
					<!-- <view class="center_list">
						<image src="../../static/images/shop.png" mode=""></image>
						<view class="tac fz26 c3">Shopping</view>
					</view> -->
					<!-- 积分商城 -->
					<view class="center_list" @click="nav('/pages/rule/rule?keyword=shopInfo')">
						<image src="../../static/images/ishop.png" mode=""></image>
						<view class="tac fz26 c3">Points mall</view>
					</view>
					<!--  -->
					<!-- <view class="center_list" @click="nav('/pages/AdPage/AdPage')">
						<image src="../../static/images/shop.png" mode=""></image>
						<view class="tac fz26 c3">testAd</view>
					</view> -->
				</view>
			</view>
			<view class="h30"></view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				customStyleAvt: {
					borderRadius: '50%'
				},
				customStyleImg: {
					borderRadius: '10rpx'
				},
				customStyle: {
					backgroundColor: "#ffdb25",
					height: "80rpx",
					border: "0",
					fontSize: "34rpx",
					color: "#fff"
				},
				gardenList: [],
				str: "&ldquo;小网格&rdquo;服务&ldquo;大民生&rdquo;，这个社区有妙招",
				checked: false,
				newUserInfo:{}
			}
		},
		onLoad() {
			// this.getList();
			if(this.userInfo && this.token) {
				this.checked = Boolean(this.userInfo.data.member_permission_status);
			} 

			// console.log(this.userInfo);
			uni.$on('refreshCenter', () => {
				this.login();
			})
		},
		onUnload() {
			uni.$off('refreshCenter');
		},
		onPullDownRefresh() {
			if(this.userInfo && this.token)  {
				this.login();
			} else {
				uni.stopPullDownRefresh()
			}
		},
		onShow() {
			this.login();
		},
		methods: {
			getMsgNum() {
				var datas = {
					
				}
				this.requestSet.getData(datas, '/V1.Member/personal_center', 'GET').then((res) => {
					if (res.status == 200) {
						this.newUserInfo = res.data;
					} else {
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
				});
			},
			change(e) {
				console.log(11)
				var datas = {
					member_id: this.userInfo.data.member_id,
					member_permission_status: Number(e),
				}
				this.requestSet.getData(datas, '/V1.Member/permissionStatus', 'POST').then((res) => {
					if (res.status == 200) {
						var _userInfo = this.userInfo;
						_userInfo.data.member_permission_status = Number(e);
						this.setUserInfo({
							..._userInfo
						})
					} else {
						this.disabled = false;
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					this.disabled = false;
				});
			},
			// 植物详情
			gardenInfo(item) {
				// '/pages/center/garden/info
				if (!this.userInfo) {
					this.login();
				} else {
					uni.navigateTo({
						url: "/pages/center/garden/info?id=" + item.id,
					})
				}

			},
			// 切割图片路径
			getPic(item) {
				if (item) {
					return item.split(',')
				} else {
					return [];
				};
			},
			btnLogin() {
				uni.navigateTo({
					url: '/pages/login/login'
				})
			},
			nav(url) {
				if (!this.token) {
					this.btnLogin();
				} else {
					uni.navigateTo({
						url: url
					})
				}

			},
			// 获取植物列表
			getList() {
				var _userJson = uni.getStorageSync('userJson');
				// if (!_userJson.useraccount || !_userJson.userpassword) return;
				if (!this.token) return;
				var datas = {
					"apipage": "main",
					"op": "mygarden",
					"pageindex": 1,
					"pagesize": "2000",
					"tokenstr": this.token
				};
				this.requestSet.getData(datas, 'api.aspx', 'post').then((res) => {
					if (res.list) {
						// 保存用户信息
						this.gardenList = res.list;
					} else {
						this.requestSet.showToast(res.returnstr || 'fail');
					};
				}).catch((err) => {
					console.log(err)
					this.disabled = false;
				});
			},

			//登录
			login() {
				var _userJson = uni.getStorageSync('userJson');
				if (!_userJson) return;
				var datas = {
					email: _userJson.email,
					password: _userJson.password,
					// #ifdef APP-PLUS
					jpushcode: plus.push.getClientInfo() ? plus.push.getClientInfo().clientid : ''
					// #endif
				};
				this.requestSet.getData(datas, '/V1.Member/emailLogin', 'POST').then((res) => {
					if (res.status == 200) {
						this.getMsgNum();
						// 保存用户信息
						this.setUserInfo(res);
						//保存用户token
						this.setToken(res.token);
					} else {
						this.requestSet.showToast(res.msg);
						// 清除登录信息
						uni.removeStorageSync('userJson');
						// 清除用户信息
						uni.removeStorageSync('userInfo');
						// 清空store用户信息
						this.setUserInfo({});
						// 清空store Token信息
						this.setToken('');
					};
				}).catch((err) => {
					console.log(err)
					this.disabled = false;
				});
			}

		}
	}
</script>

<style>
	page {
		background-color: #f7f8fb;
	}

	.avt {
		width: 122rpx;
		height: 122rpx;
		display: block;
		border-radius: 50%;
	}

	.mr40 {
		margin-right: 40rpx;
	}

	.p20_0 {
		padding: 20rpx 0;
	}

	.center_list {
		width: 33.333%;
		margin: 20rpx 0;
	}

	.center_list image {
		width: 78rpx;
		height: 78rpx;
		display: block;
		border-radius: 50%;
		margin: auto;

	}

	.botany_list {
		margin: 0 0rpx 30rpx 30rpx;
		width: 130rpx;
	}

	.botany_list image {
		width: 130rpx;
		height: 130rpx;
		display: block;
		border-radius: 10rpx;
	}

	.add_btn {
		width: 130rpx;
		height: 130rpx;
		border-radius: 10rpx;
		border: 1rpx solid #e6e7eb;
		box-sizing: border-box;
		text-align: center;
		line-height: 130rpx;
	}

	.top_num {
		line-height: 34rpx;
	}
</style>
