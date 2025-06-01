<template>
	<view>
		
	</view>
</template>

<script>
	export default {
		data() {
			return {
				
			}
		},
		onLoad() {
			this.init();
		},
		methods: {
			async init() {
				var datas = {
					limit: 100,
					page: 1,
				};
				console.log(1);
				var listt = await this.requestSet.getData(datas, '/V1.DiscoverCate/index', 'POST');
				console.log(listt);
				console.log(2);
			},
		}
	}
</script>

<style>

</style>
