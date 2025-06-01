<template>
	<view>

		<markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer>
		<view v-if="gardenInfo.body">
			<view class="swiper_box">
				<swiper :autoplay="true" :interval="5000" :duration="500" style="height: 640rpx;">
					<swiper-item v-for="(item,index) in getPic(gardenInfo.body.img)" v-if="item">
						<view class="swiper-item">
							<view class="img" :style="{backgroundImage:` url(${url}${item})`}"></view>
						</view>
					</swiper-item>
				</swiper>
				<view class="g_name_bo">
					<view class="p0_30">
						<view class="fz40 cf">{{gardenInfo.body.plant_name}}</view>
						<view class="fz28 cf">{{gardenInfo.body.common_name}}</view>
					</view>
				</view>
			</view>
			<!--  -->
			<view class="info_box">
				<!-- 圆形导航 -->
				<view class="">
					<!-- 导航按钮 -->
					<view class="btn  flex juc itc trans" :class="{'rotate45' : isNav}" @click="showNav">
						<view class="icontianjia fz50"></view>
					</view>
					<!-- 导航列表 -->
					<view class="nav_box" :style="{zIndex: isNav ? '10': '1'}">
						<!-- <view class="f_list trans" v-for="(item,index) in navList" :style="{backgroundImage: 'url(' +item.url+ ')', transform: `rotate(${computedRotate(index)}deg)`}"> -->
						<view class="f_list trans" :class="{'active' : isNav}" v-for="(item,index) in navList"
							:style="{backgroundImage: 'url(' +bgList[index].url+ ')', transform: `rotate3d(0,0,1,${computedRotate(index)}deg) translate(0,-50%)`}"
							@click="alarm(item)">
							<view class="">
								<image :src="url + item.icon" mode="" class="nicon"
									:style="{transform: `rotate(-${computedRotate(index)}deg)`}">
								</image>
							</view>
						</view>
					</view>
				</view>
				<view class="tab_box">
					<view class="flex itc">
						<view class="flex_1 tab tac" :class="{'active' :tabIndex == 0}" @click="tabIndex = 0">
							<view class="iconshumiao fz60"></view>
						</view>
						<view class="flex_1 tab tac " :class="{'active' :tabIndex == 1}" @click="tab(1)">
							<view class="iconicon_notice fz50"></view>
						</view>
					</view>
				</view>
				<!-- 列表 -->
				<view class="tab_view_box">
					<!-- tab1 -->
					<view class="tab_view" v-show="tabIndex == 0">
						<view class="p30 fz30 c3">
							{{gardenInfo.body.plant_introduction}}
						</view>
						<view class="h20"></view>
						<view class="p0_30">
							<!-- 1 -->
							<view class="flex mb40">
								<view class="mr30">
									<image src="../../../static/images/gicon_03.jpg" mode="" class="setsImg"></image>
								</view>
								<view class="flex_1">
									<view class="fz28 c3 mt10 mb5 fw9">Duration</view>
									<view class="fz28 c6 lh50">{{gardenInfo.body.duration || 'N/A'}}</view>
								</view>
							</view>
							<!-- 2 -->
							<view class="flex mb40">
								<view class="mr30">
									<image src="../../../static/images/gicon_05.jpg" mode="" class="setsImg"></image>
								</view>
								<view class="flex_1">
									<view class="fz28 c3 mt10 mb5 fw9">Flower Color</view>
									<view class="fz28 c6 lh50">{{gardenInfo.body.flower_color || 'N/A'}}</view>
								</view>
							</view>
							<!-- 3 -->
							<view class="flex mb40">
								<view class="mr30">
									<image src="../../../static/images/gicon_11.jpg" mode="" class="setsImg"></image>
								</view>
								<view class="flex_1">
									<view class="fz28 c3 mt10 mb5 fw9">Fertilization</view>
									<view class="fz28 c6 lh50">{{gardenInfo.body.fertilization || 'N/A'}}</view>
								</view>
							</view>
							<!-- 4 -->
							<view class="flex mb40">
								<view class="mr30">
									<image src="../../../static/images/gicon_09.jpg" mode="" class="setsImg"></image>
								</view>
								<view class="flex_1">
									<view class="fz28 c3 mt10 mb5 fw9">Water</view>
									<view class="fz28 c6 lh50">{{gardenInfo.body.water || 'N/A'}}</view>
								</view>
							</view>
							<!-- 5 -->
							<view class="flex mb40">
								<view class="mr30">
									<image src="../../../static/images/gicon_21.jpg" mode="" class="setsImg"></image>
								</view>
								<view class="flex_1">
									<view class="fz28 c3 mt10 mb5 fw9">Exposure</view>
									<view class="fz28 c6 lh50">{{gardenInfo.body.exposure || 'N/A'}}</view>
								</view>
							</view>
							<!-- 6 -->
							<view class="flex mb40">
								<view class="mr30">
									<image src="../../../static/images/gicon_23.jpg" mode="" class="setsImg"></image>
								</view>
								<view class="flex_1">
									<view class="fz28 c3 mt10 mb5 fw9">Soil</view>
									<view class="fz28 c6 lh50">{{gardenInfo.body.soil || 'N/A'}}</view>
								</view>
							</view>
							<!-- 7 -->
							<view class="flex mb40">
								<view class="mr30">
									<image src="../../../static/images/gicon_15.jpg" mode="" class="setsImg"></image>
								</view>
								<view class="flex_1">
									<view class="fz28 c3 mt10 mb5 fw9">Minimum Tempature</view>
									<view class="fz28 c6 lh50">{{gardenInfo.body.minimum_tempature || 'N/A'}}</view>
								</view>
							</view>
							<!-- 8 -->
							<view class="flex mb40">
								<view class="mr30">
									<image src="../../../static/images/gicon_17.jpg" mode="" class="setsImg"></image>
								</view>
								<view class="flex_1">
									<view class="fz28 c3 mt10 mb5 fw9">Blooming</view>
									<view class="fz28 c6 lh50">{{gardenInfo.body.blooming || 'N/A'}}</view>
								</view>
							</view>
						</view>
					</view>
					<!-- tab2 -->
					<view class="tab_view" v-show="tabIndex == 1">
						<view class="p30">
							<!-- 已设置 -->
							<view class="line_title fz34 c3">Set</view>
							<view class="h40"></view>
							<view class="list_box" v-if="setList.length">
								<view class="flex itc bb1 " v-for="(item,index) in setList">
									<view class=" mr20 tac">
										<image :src="url + item.remind_icon" mode="widthFix"
											class="setIcon"></image>
									</view>
									<view class=" fz20 c3 mr20 oh1" style="width: 120rpx;">{{item.remind_name}}</view>
									<view class=" flex_1 mr20">
										<view class="fz22">{{fomtTime(item.start_time)}}</view>
										<view class="fz22" v-if="item.day">{{fomtTime(item.end_time)}}</view>
									</view>
									<view class="fz20 mr20"><text v-if="item.day">{{getForType(item.day)}}</text> once</view>
									<view class="fz30 red iconfont iconshanchu" @click="delAlarm(item,index)"></view>
								</view>
							</view>
							<view class="" v-else>
								<view class="tac lh80 fz24 c9">No List</view>
							</view>
							<!-- 已提醒 -->
							<view class="h40"></view>
							<view class="line_title fz34 c3">Care Schedule</view>
							<view class="h40"></view>
							<view class="list_box" v-if="alarmList.length">
								<view class="flex itc bb1 " v-for="(item,index) in alarmList">
									<view class=" mr20 tac">
										<image :src="url + item.remind_icon" mode="widthFix"
											class="setIcon"></image>
									</view>
									<view class=" fz20 c3 mr20 oh1" style="width: 120rpx;">{{item.remind_name}}</view>
									<view class=" flex_1 mr20">
										<view class="fz22">{{fomtTime(item.start_time)}}</view>
									</view>
								</view>
								<view class="tac lh80 fz24 c9">No More</view>
							</view>
							<view class="" v-else>
								<view class="tac lh80 fz24 c9">No List</view>
							</view>
						</view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	var bgList = [{
		name: 'Water',
		iconUrl: '../../../static/images/nicon1.png',
		url: '../../../static/images/f1.png'
	}, {
		name: 'Repot',
		iconUrl: '../../../static/images/nicon2.png',
		url: '../../../static/images/f2.png'
	}, {
		name: 'Prune',
		iconUrl: '../../../static/images/nicon3.png',
		url: '../../../static/images/f3.png'
	}, {
		name: 'Fertilizer',
		iconUrl: '../../../static/images/nicon4.png',
		url: '../../../static/images/f4.png'
	}, {
		name: 'Others',
		iconUrl: '../../../static/images/nicon5.png',
		url: '../../../static/images/f5.png'
	}, {
		name: 'Harvest',
		iconUrl: '../../../static/images/nicon6.png',
		url: '../../../static/images/f1.png'
	}, {
		name: 'Pesticides',
		iconUrl: '../../../static/images/nicon7.png',
		url: '../../../static/images/f3.png'
	}, {
		name: 'Sow',
		iconUrl: '../../../static/images/nicon8.png',
		url: '../../../static/images/f4.png'
	}]
	export default {
		data() {
			return {
				param: {},
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				tabIndex: 0,
				isNav: false,
				navList: [],
				bgList: bgList,
				gardenInfo: {},
				param: {},
				list: [],
				setList: [], //已设置列表
				alarmList: [], // 已提醒列表
			}
		},
		onLoad(option) {
			this.param = option;
		},
		onShow() {
			this.getList();
		},
		onNavigationBarButtonTap(e) {
			if (e.float = "right") {
				uni.showModal({
					title: 'Tips',
					content: 'Confirm deletion',
					cancelText: "Cancel",
					confirmText: "OK",
					success: (res) => {
						if (res.confirm) {
							uni.showLoading({
								title: 'Loading',
								mask: true,
							});
							var datas = {
								ids: this.param.id
							};
							this.requestSet.getData(datas, '/V1.Garden/delete', 'DELETE').then((res) => {
								if (res.status == 200) {
									this.requestSet.showToast('Success');
									uni.$emit('delGarden', this.param.id);
									setTimeout(() => {
										uni.navigateBack({
											delta: 1
										})
									}, 1000);
								} else {
									this.requestSet.showToast(res.msg);
								};
							}).catch((err) => {

							});

						}
					}
				});

			}
		},
		methods: {
			// 删除提醒
			delAlarm(item ,index) {
				uni.showModal({
					title: 'Tips',
					content: 'Confirm deletion',
					confirmText: "OK",
					cancelText: "Cancel",
					success: (res) => {
						if (res.confirm) {
							uni.showLoading({
								title: 'Loading',
								mask: true,
							});
							var datas = {
								id: item.id
							};
							this.requestSet.getData(datas, '/V1.Garden/deleteRemind', 'GET').then((res) => {
								if (res.status == 200) {
									this.setList.splice(index, 1);
								} else {
									this.requestSet.showToast(res.msg);
								};
							}).catch((err) => {
				
							});
						}
					}
				});
			},
			// 格式化时间
			fomtTime(time) {
				if(time) {
					var _list = time.split(' ');
					var _data = _list[0].split('-');
					return `${_data[1]}-${_data[2]}-${_data[0]} ${_list[1]}`
				}
				
			},
			// 获取设置的循环类型
			getForType(day) {
				if(day>=365) {
					return `${day/365} Year/`;
				} else if(day>=30) {
					return `${day/30} Mounth/`;
				} else {
					return `${day} Day/`;
				}
			},
			tab(num) {
				this.tabIndex = num;
				this.getList();
			},
			// 切割图片路径
			getPic(item) {
				if (item) {
					return item.split(',')
				} else {
					return [];
				};
			},
			// 获取花园详情数据
			getList() {
				var datas = {
					id: this.param.id,
				};
				this.requestSet.getData(datas, '/V1.Garden/view', 'GET').then((res) => {
					if (res.status == 200) {
						this.gardenInfo = res.data;
						this.navList = res.data.icons;
					} else {
						this.requestSet.showToast(res.msg);
					};
					this.getRemind(0);
					this.getRemind(1);
					setTimeout(() => {
						this.isMark = false;
					}, 500)
				}).catch((err) => {
					console.log(err)
					this.isMark = true;
					this.markType = 2;
				});
			},
			// 获取提醒信息
			getRemind(type) {
				var datas = {
					type: type,
					limit: 10000,
					page: 1,
					garden_id: this.param.id
				};
				if (type === 1) {
					datas.start_time = this.$r.getNextDate(-7);
					datas.end_time = this.$r.getNextDate(+1);
					// datas.start_time = "2022-01-14 00:00:00";
					// datas.end_time = "2022-01-22 00:00:00";
				}
				this.requestSet.getData(datas, '/V1.Garden/show_Remind', 'GET').then((res) => {
					if (res.status == 200) {
						if (type === 0) {
							this.setList = res.data.list;
							this.setAlarmList(res.data.list)
						} else if (type === 1) {
							this.alarmList = res.data.list;
						}

					} else {
						this.requestSet.showToast(res.msg);
					}

				}).catch((err) => {
					this.isMark = true;
					this.markType = 2;
				});
			},
			//添加闹钟
			alarm(item) {
				// console.log(item);
				uni.navigateTo({
					url: "/pages/center/garden/setAlarm?id=" + item.id + "&name=" + item.name + "&gid=" + this
						.param.id
				})
			},
			// 计算旋转角度
			computedRotate(index) {
				var deg = index * (360 / this.navList.length);
				return deg;
			},
			showNav() {
				if (this.isNav) {
					this.isNav = false;
				} else {
					this.isNav = true;
				}
			},
			refresh(data) { //刷新当前页数据
				if (data == this.timestamp) {
					this.getList();
				}
			},
		}
	}
</script>

<style>
	.img {
		width: 100%;
		height: 640rpx;
		background-size: cover;
		background-position: center center;
	}

	.info_box {
		background: #fff;
		border-top-left-radius: 30rpx;
		border-top-right-radius: 30rpx;
		position: relative;
		top: -40rpx;
	}

	.title {
		border-bottom: 6rpx solid #f7f7f7;
		padding: 20rpx 30rpx;
	}

	.line_title {
		line-height: 34rpx;
		height: 34rpx;
		border-left: 6rpx solid #5fcfa0;
		text-indent: 30rpx;
	}

	.pl50 {
		padding-left: 50rpx;
	}

	.swiper_box {
		position: relative;
	}

	.g_name_bo {
		position: absolute;
		top: 350rpx;
		left: 0;
	}

	.tab_box {}

	.tab {
		line-height: 160rpx;
		border-bottom: solid #f6f7f9 10rpx;
		box-sizing: border-box;
		color: #dadada;
	}

	.tab_box .active {
		color: #3ee6c0;
		border-bottom: solid #3ee6c0 10rpx;
	}

	.btn {

		width: 130rpx;
		height: 130rpx;
		border-radius: 50%;
		background-color: #3ee6c0;
		text-align: center;
		line-height: 130rpx;
		color: #fff;
		position: absolute;
		left: 50%;
		top: -65rpx;
		margin-left: -65rpx;
		z-index: 12;
	}

	.icontianjia {
		line-height: 50rpx;
		height: 50rpx;
		width: 50rpx;
		overflow: hidden;
	}

	.rotate45 {
		transform: rotate(-45deg);
	}

	.setList {
		width: 50%;
		height: 375rpx;
	}

	.setImg {
		width: 200rpx;
		height: 200rpx;
	}

	.line_title {
		line-height: 34rpx;
		height: 34rpx;
		border-left: 6rpx solid #5fcfa0;
		text-indent: 30rpx;
	}

	.yuan {
		width: 26rpx;
		height: 26rpx;
		border-radius: 50%;
		box-sizing: border-box;
		border: 4rpx solid #fad812;
		margin-top: 4rpx;
	}

	.line {
		height: 110px;
		width: 2rpx;
		border-left: 2rpx dashed #aeaeae;
		margin: auto;
	}

	.listicon {
		width: 46rpx;
		height: 46rpx;
	}

	.f_list {
		width: 0rpx;
		height: 255rpx;
		display: block;
		background-size: cover;
		background-position: center center;
		overflow: hidden;
		position: absolute;
		top: 50%;
		left: 50%;
		margin-left: -94rpx;
		margin-top: -127.5rpx;
	}

	.nav_box .active {
		width: 188rpx;
		height: 255rpx;
	}

	.nicon {
		width: 52rpx;
		height: 52rpx;
		display: block;
		margin: auto;
		margin-top: 24rpx;
		border-radius: 50%;
	}

	.nav_box {
		height: 510rpx;
		width: 510rpx;
		position: absolute;
		left: 50%;
		margin-left: -255rpx;
		top: -255rpx;
		z-index: 1;
	}

	.tab_box {
		position: relative;
		z-index: 3;
	}

	.setsImg {

		display: block;
		width: 100rpx;
		height: 100rpx;
	}

	.g_name_bo {
		text-shadow: 2rpx 5rpx 5rpx #000;
	}

	.setIcon {
		width: 80rpx;
		display: block;
	}
	
	.dian{
		display: inline-block;
		width: 70rpx;
	}
	
	.list_box .flex{
		padding: 20rpx 0;
	}
</style>
