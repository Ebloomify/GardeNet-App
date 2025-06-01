<template>
	<view>

		<!-- <markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer> -->
		<view class="swiper_box">
			<swiper :autoplay="true" :interval="5000" :duration="500" style="height: 640rpx;">
				<swiper-item v-for="(item,index) in getPic(param.pics)" v-if="item">
					<view class="swiper-item">
						<view class="img" :style="{backgroundImage:` url(${url}${item})`}"></view>
					</view>
				</swiper-item>
			</swiper>
			<view class="g_name_bo">
				<view class="p0_30">
					<view class="fz40 cf">{{param.name}}</view>
					<view class="fz28 cf">{{param.descripion}}</view>
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
					<view class="f_list trans" :class="{'active' : isNav}" v-for="(item,index) in navList" :style="{backgroundImage: 'url(' +item.url+ ')', transform: `rotate3d(0,0,1,${computedRotate(index)}deg) translate(0,-50%)`}"
					 @click="alarm(item)">
						<view class="">
							<image :src="item.iconUrl" mode="" class="nicon" :style="{transform: `rotate(-${computedRotate(index)}deg)`}">
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
						{{param.descripion}}
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
								<view class="fz28 c6 lh50">{{param.n1 || 'N/A'}}</view>
							</view>
						</view>
						<!-- 2 -->
						<view class="flex mb40">
							<view class="mr30">
								<image src="../../../static/images/gicon_05.jpg" mode="" class="setsImg"></image>
							</view>
							<view class="flex_1">
								<view class="fz28 c3 mt10 mb5 fw9">Flower Color</view>
								<view class="fz28 c6 lh50">{{param.n2 || 'N/A'}}</view>
							</view>
						</view>
						<!-- 3 -->
						<view class="flex mb40">
							<view class="mr30">
								<image src="../../../static/images/gicon_11.jpg" mode="" class="setsImg"></image>
							</view>
							<view class="flex_1">
								<view class="fz28 c3 mt10 mb5 fw9">Fertilization</view>
								<view class="fz28 c6 lh50">{{param.fertilization || 'N/A'}}</view>
							</view>
						</view>
						<!-- 4 -->
						<view class="flex mb40">
							<view class="mr30">
								<image src="../../../static/images/gicon_09.jpg" mode="" class="setsImg"></image>
							</view>
							<view class="flex_1">
								<view class="fz28 c3 mt10 mb5 fw9">Water</view>
								<view class="fz28 c6 lh50">{{param.water || 'N/A'}}</view>
							</view>
						</view>
						<!-- 5 -->
						<view class="flex mb40">
							<view class="mr30">
								<image src="../../../static/images/gicon_21.jpg" mode="" class="setsImg"></image>
							</view>
							<view class="flex_1">
								<view class="fz28 c3 mt10 mb5 fw9">Exposure</view>
								<view class="fz28 c6 lh50">{{param.exposure || 'N/A'}}</view>
							</view>
						</view>
						<!-- 6 -->
						<view class="flex mb40">
							<view class="mr30">
								<image src="../../../static/images/gicon_23.jpg" mode="" class="setsImg"></image>
							</view>
							<view class="flex_1">
								<view class="fz28 c3 mt10 mb5 fw9">Soil</view>
								<view class="fz28 c6 lh50">{{param.soil || 'N/A'}}</view>
							</view>
						</view>
						<!-- 7 -->
						<view class="flex mb40">
							<view class="mr30">
								<image src="../../../static/images/gicon_15.jpg" mode="" class="setsImg"></image>
							</view>
							<view class="flex_1">
								<view class="fz28 c3 mt10 mb5 fw9">Minimum Tempature</view>
								<view class="fz28 c6 lh50">{{param.minimum || 'N/A'}}</view>
							</view>
						</view>
						<!-- 8 -->
						<view class="flex mb40">
							<view class="mr30">
								<image src="../../../static/images/gicon_17.jpg" mode="" class="setsImg"></image>
							</view>
							<view class="flex_1">
								<view class="fz28 c3 mt10 mb5 fw9">Blooming</view>
								<view class="fz28 c6 lh50">{{param.blooming || 'N/A'}}</view>
							</view>
						</view>
					</view>
				</view>
				<!-- tab2 -->
				<view class="tab_view" v-show="tabIndex == 1">
					<view class="p30">
						<view class="line_title fz34 c3">Care Schedule</view>
						<view class="h40"></view>
						<view class="list_box">
							<view class="list flex" v-for="(item,index) in list">
								<!-- <view class="list flex" v-for="(item,index) in list"> -->
								<view class="tac mr20">
									<view class="fz24 c9">{{addDay(item.addtime,item.timerdays).days}}</view>
									<view class="fz24 c9">{{addDay(item.addtime,item.timerdays).time}}</view>
								</view>
								<view class="mr20">
									<view class="yuan"></view>
									<view class="line" v-if="index !=list.length-1"></view>
								</view>
								<view class="mr20">
									<image :src="getIcon(item.name.split('-')[1])" mode="" class="listicon"></image>
								</view>
								<view class="fz30 c3">{{item.name.split('-')[1]}}</view>
							</view>
						</view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	var navList = [{
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
				navList: navList,
				param: {},
				list: []
			}
		},
		onLoad(e) {
			this.param = JSON.parse(e.item);
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
								apipage: "main",
								op: "mygarden_del",
								id: this.param.id,
								tokenstr: this.token
							};
							this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
								this.requestSet.showToast(res.returnstr);
								if (res.error == 0) {
									uni.$emit('delGarden', this.param.id);
									setTimeout(() => {
										uni.navigateBack({
											delta: 1
										})
									}, 1000);
								} else {

								};
							}).catch((err) => {

							});
						}
					}
				});

			}
		},
		methods: {
			// 增加天数
			addDay(datetime, days) {
				var old_time = new Date(datetime.replace(/-/g, "/")); //替换字符，js不认2013-01-31,只认2013/01/31
				var fd = new Date(old_time.valueOf() + days * 24 * 60 * 60 * 1000); //日期加上指定的天数
				var new_time = fd.getFullYear() + "-";
				var month = fd.getMonth() + 1;
				if (month >= 10) {
					new_time += month + "-";
				} else {
					//在小于10的月份上补0
					new_time += "0" + month + "-";
				}
				if (fd.getDate() >= 10) {
					new_time += fd.getDate();
				} else {
					//在小于10的日期上补0
					new_time += "0" + fd.getDate();
				};

				// return new_time + ; //输出格式：2013-01-02
				return {
					days: new_time,
					time: datetime.split(' ')[1]
				}; //输出格式：2013-01-02
			},
			// 显示未到结束时间的提醒
			getTimeShow(time) {
				var currentTime = Date.parse(new Date());
				var endTime = new Date(time).getTime();
				return endTime > currentTime;
			},
			// 获取列表图标
			getIcon(str) {
				if (str) {
					for (var i = 0; i < navList.length; i++) {
						if (navList[i].name == str) {
							return navList[i].iconUrl;
						}
					}
				} else {
					return '';
				}

			},
			tab(num) {
				this.tabIndex = num;
				this.getList();
			},
			// 切割图片路径
			getPic(item) {
				if (item) {
					return item.split('^')
				} else {
					return [];
				};
			},
			// 获取花园提醒数据
			getList() {
				var datas = {
					apipage: 'main',
					op: 'mygarden_timer_info_all',
					id: this.param.id,
					tokenstr: this.token,
					starttime: "2021-02-02",
					endtime: "2099-03-09",
				};
				this.requestSet.getData(datas, 'api.aspx', 'GET').then((res) => {
					if (res.error == 0) {
						// getTimeShow(item.endtime)
						var _list = [];
						var _data = res.data;
						for (var i = 0; i < _data.length; i++) {
							if (this.getTimeShow(_data[i].endtime)) {
								_list.push(_data[i])
							}
						}
						this.list = _list;
					} else {
						this.requestSet.showToast(res.returnstr);
					}

				}).catch((err) => {

				});
			},
			//添加闹钟
			alarm(item) {
				uni.navigateTo({
					url: "/pages/center/garden/setAlarm?id=" + this.param.id + "&name=" + item.name
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
			}
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
</style>
