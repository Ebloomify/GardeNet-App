<template>
	<view>
		<!-- <markLayer :from="timestamp" :type="markType" @markRefresh="refresh" v-if="isMark"></markLayer> -->
		<view class="h100 flex itc bb1 p0_30 bgf" @click="show = true">
			<view class="fz30 c3 flex_1">Repeat</view>
			<view class="fz28 c3 mr20">{{rwpeat[rwpeatIndex[0]].children[rwpeatIndex[1]].label}}</view>
			<view class="iconarrow-right-copy-copy c9"></view>
		</view>
		<!-- 开始时间 -->
		<view class="h100 flex itc bb1 p0_30 bgf" @click="showTime('satrTime')">
			<view class="fz30 c3 flex_1">Reminding time</view>
			<view class="fz28 c3 mr20">{{satrTime || 'Please select the time'}}</view>
			<view class="iconarrow-right-copy-copy c9"></view>
		</view>
		<!-- 结束时间 -->
		<view class="h100 flex itc bb1 p0_30 bgf" v-show="rwpeatIndex[0] != 0" @click="showTime('endTime')">
			<view class="fz30 c3 flex_1">End time</view>
			<view class="fz28 c3 mr20">{{endTime || 'Please select the time'}}</view>
			<view class="iconarrow-right-copy-copy c9"></view>
		</view>
		<!--  -->
		<!-- 选择重复模式组件 -->
		<u-select confirm-text="OK" cancel-text="Cancel" v-model="show" :list="rwpeat" @confirm="confirm"
			:default-value="[rwpeatIndex]" mode="mutil-column-auto"></u-select>
		<!-- 开始时间选择器 -->
		<u-picker confirm-text="OK" cancel-text="Cancel" v-model="timeShow" mode="time" :params="timeParams"
			@confirm="timeConfirm" :show-time-tag="false"></u-picker>
		<!-- 结束时间选择器 -->
		<u-picker confirm-text="OK" cancel-text="Cancel" v-model="timeShow1" mode="time" :params="timeParams1"
			@confirm="timeConfirm" :show-time-tag="false"></u-picker>
		<!--  -->
		<view class="p30">
			<u-button type="primary" clas="btn h100 " :custom-style="customStyle" :ripple="true" :disabled="disabled"
				@click="submit">submit</u-button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				timestamp: Date.parse(new Date()), //时间戳等于页面名称
				isMark: true, //是否显示页面遮罩 
				markType: 1,
				url: this.requestSet.imgUrl, //配置资源域名-小程序不支持requestSet.ajaxUrl
				param: {},
				disabled: false,
				customStyle: {
					height: "80rpx",
					borderRadius: "40rpx",
					backgroundImage: "linear-gradient(to right, #52d0bb, #48d39a)"
				},
				rwpeat: [{
					label: "Never",
					value: 0,
					children: [{
						value: 0,
						label: 'Never'
					}]
				}, {
					label: "Day",
					value: 1,
					children: []
				}, {
					label: "Month",
					value: 2,
					children: []
				}, {
					label: "Year",
					value: 3,
					children: []
				}], //循环数据
				rwpeatIndex: ['0', '0'], //循环索引
				show: false, // 
				dayArr: [],
				monthArr: [],
				yearArr: [],
				timeParams: {
					year: true,
					month: true,
					day: true,
					hour: true,
					minute: true,
					second: false
				},
				timeParams1: {
					year: true,
					month: true,
					day: true,
					hour: true,
					minute: true,
					second: false
				},
				timeStr: "", //选择时间标志
				timeShow: false, //开始时间选择器标志
				timeShow1: false, //结束时间选择器标志
				satrTime: "", // 开始时间
				endTime: "", // 结束时间
			}
		},
		onLoad(option) {
			this.param = option;
			uni.setNavigationBarTitle({
				title: option.name
			});
			this.setArr();
			this.initAlarm();
			// 判断并提示获取通知权限
			this.$r.setPermissions();
		},
		methods: {
			initAlarm() {
				for (var i = 0; i < this.alarmLists.length; i++) {
					if (this.alarmLists[i].remind_name == this.param.name) {
						console.log(this.alarmLists[i]);
					}
				}
			},
			// 获取间隔时间
			getIntervalDay() {
				if (this.rwpeatIndex[0] == 0) {
					// 不循环
					return '';
				} else if (this.rwpeatIndex[0] == 1) {
					// 天循环
					var _num = this.rwpeat[this.rwpeatIndex[0]].children[this.rwpeatIndex[1]].value;
					return _num;
				} else if (this.rwpeatIndex[0] == 2) {
					// 月循环
					var _num = this.rwpeat[this.rwpeatIndex[0]].children[this.rwpeatIndex[1]].value;
					return _num * 30;
				} else if (this.rwpeatIndex[0] == 3) {
					// 年循环
					var _num = this.rwpeat[this.rwpeatIndex[0]].children[this.rwpeatIndex[1]].value;
					return _num * 365;
				}
			},
			submit() {
				if (!this.satrTime) {
					this.requestSet.showToast('Please Select start time');
					return;
				};
				// 选择了循环提醒
				if (this.rwpeatIndex[0] != 0) {
					if (!this.endTime) {
						this.requestSet.showToast('Please Select end time');
						return;
					};
				};
				var datas = {
					garden_id: this.param.gid,
					id: this.param.id,
					day: this.getIntervalDay() || 0, //间隔时间 单位：天
					start_time: this.satrTime, //每次的提醒时间
					end_time: '', //提醒截止时间
				};
				if (this.rwpeatIndex[0] != 0) {
					datas.end_time = this.endTime;
				}
				uni.showLoading({
					mask: true,
					title: "Loading"
				})
				this.disabled = true;
				this.requestSet.getData(datas, '/V1.Garden/setRemind', 'POST').then((res) => {
					if (res.status == 200) {
						this.requestSet.showToast('Success');
						setTimeout(() => {
							uni.navigateBack({
								delta: 1
							})
						}, 1000);

					} else if (res.status == 202) {
						this.disabled = false;
						this.requestSet.showToast('Login to the app again and try again');
					} else {
						this.disabled = false;
						this.requestSet.showToast(res.msg);
					};
				}).catch((err) => {
					this.disabled = false;
				});
			},

			//  选择时间
			showTime(str) {
				this.timeStr = str;
				if (str == 'satrTime') {
					this.timeShow = true;
				} else {
					this.timeShow1 = true;
				}
			},
			// 选择时间
			timeConfirm(e) {
				var _time = e.year
				if (e.month) {
					_time += '-' + e.month;
				};
				if (e.day) {
					_time += '-' + e.day;
				};
				if (e.hour) {
					_time += ' ' + e.hour;
				};
				if (e.minute) {
					_time += ':' + e.minute;
				};
				this[this.timeStr] = _time;
			},
			//选择循环模式
			confirm(e) {
				this.endTime = '';
				this.rwpeatIndex[0] = e[0].value;
				this.rwpeatIndex[1] = e[1].value == 0 ? e[1].value : e[1].value - 1;
			},
			//  设置旋转数据
			setArr() {
				for (var i = 1; i < 30; i++) {
					if (i < 6) {
						this.dayArr.push({
							value: i,
							label: i + ' Day'
						});
						this.monthArr.push({
							value: i,
							label: i + ' Mounth'
						});
						this.yearArr.push({
							value: i,
							label: i + ' Year'
						});
					} else if (i < 12) {
						this.dayArr.push({
							value: i,
							label: i + ' Day'
						});
						this.monthArr.push({
							value: i,
							label: i + ' Mounth'
						});
					} else {
						this.dayArr.push({
							value: i,
							label: i + ' Day'
						});
					}
				};
				this.rwpeat[1].children = this.dayArr;
				this.rwpeat[2].children = this.monthArr;
				this.rwpeat[3].children = this.yearArr;
			}
		}
	}
</script>

<style>
	page {
		background-color: #f4f4f4;
	}
</style>