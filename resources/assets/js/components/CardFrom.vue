<template>
	<div class="container">
		<el-row>
			<el-col>
				<el-select @change="selectClass" v-model="itemSelect" placeholder="请选择职业">
				    <el-option
				      v-for="item in classItem"
				      :key="item.id"
				      :label="item.name"
				      :value="item.id">
				    </el-option>
				</el-select>
				<div style="display: inline-block;">
					<el-input
						clearable
					    placeholder="请输入内容"
					    prefix-icon="el-icon-search"
					    v-model="serachText">
					</el-input>

				</div>
				<el-checkbox v-model="isShowImg">是否显示卡牌图片</el-checkbox>
			</el-col>
		</el-row>
	  	<el-table
		    :data="tableData"
		    stripe
		    @cell-mouse-enter="imgVisable"
		    @cell-mouse-leave="imgHidden"
		    style="width: 100%">
		    <el-table-column
		      prop="id"
		      label="ID"
		      width="70">
		    </el-table-column>
		    <el-table-column
		      prop="name"
		      label="名称"
		      width="180">
		    </el-table-column>
		    <el-table-column
		      label="技能">
		      	<template slot-scope="scope">
	             	<div v-html="scope.row.description"></div>
	        	</template>
		    </el-table-column>
		    <el-table-column
		      prop="classes[0].name"
		      width="120"
		      label="职业名称">
		    </el-table-column>
		    <el-table-column
		      prop="expand.name"
		      width="150"
		      label="拓展包">
		    </el-table-column>
		    <el-table-column
		      prop="cardtype"
		      width="80"
		      label="类型">
		    </el-table-column>
		    <el-table-column
		      prop="condition"
		      width="80"
		      label="环境">
		    </el-table-column>
		    <el-table-column
		      prop="cost"
		      width="80"
		      align="center"
		      sortable
		      label="费用">
		    </el-table-column>
		    <el-table-column
		      prop="attack"
		      width="110"
		      :formatter="formatter"
		      align="center"
		      sortable
		      label="攻击力">
		    </el-table-column>
		    <el-table-column
		      prop="health"
		      width="110"
		      :formatter="formatter"
		      align="center"
		      sortable
		      label="生命值">
		    </el-table-column>
		  </el-table>
		<div class="block">
		    <el-pagination
		      @size-change="handleSizeChange"
		      @current-change="handleCurrentChange"
		      :current-page="page"
		      :page-size="pagetotal"
		      :page-count="pageSize"
		      layout="total, sizes ,prev, pager, next, jumper"
		      :total="total">
		    </el-pagination>
		</div>
		<div @mousemove="imgHover" id="img-box" :style="'top:'+ ((clientY-imgHeight)>0?(clientY-imgHeight):clientY) +'px;left:'+clientX+'px;'" class="img-box" v-show="imgShow&&isShowImg">
			<img :src="img" style="height:100%;width: auto;">
		</div>
	</div>
</template>
<script>
export default {
	data() {
      return {
      	serachText:"",
      	isShowImg:false,
      	classItem:[],
      	itemSelect:[],
      	imgWidth:300,
      	imgHeight:300,
      	clientX:0,
      	clientY:0,
      	img:"",
      	imgShow:true,
      	page:1,
      	total:0,
      	pagetotal:10,
      	pageSize:0,
        tableData: []
      }
    },
    mounted(){
    	this.getPageInfo();
    	this.getPage();
    	this.getClass();
    },
    methods:{
    	selectClass(value){
    		this.getClassPage()
    	},
    	getClassPage(){
    		this.$axios.get('/card',{
    			params: {
			      page: this.page,
			      page_sizes:this.pagetotal,
			      selectclass:this.itemSelect
			    }
    		}).then((respose)=>{
    			this.tableData = respose.data.data
    			this.pageSize = respose.data.last_page;
    			this.total = respose.data.total;
    		}).catch((error) => {
    			this.$message(error)
    		})
    	},
    	getClass(){
    		this.$axios.get('/class').then((respose) => {
    			this.classItem = respose.data;
    		}).catch((error) => {
    			this.$message({
    				type:"error",
    				message:"出错了！"+error
    			})
    		})
    	},
    	imgHover(event){
    		this.clientX = event.clientX
    		this.clientY = event.clientY
    		this.imgShow = true;
    	},
    	imgVisable(row, column, cell, event){
    		this.clientX = event.clientX
    		this.clientY = event.clientY
    		this.img = row.image.path
    		this.imgShow = true;
    	},
    	imgHidden(row, column, cell, event){
    		this.imgShow = false;
    	},
    	getPageInfo(){
    		this.$axios.get('/card/pageinfo',{
    			params: {
			      page_sizes:this.pagetotal,
			      selectclass:this.itemSelect
			    }
    		}).then((respose) => {
    			this.pageSize = respose.data.last_page;
    			this.total = respose.data.total;
    			this.tableData = respose.data.data
    		}).catch((error) => {
    			this.$message({
		          message: '出错了!'+error,
		          type: 'warning'
		        });
    		})
    	},

    	getPage(){
    		this.$axios.get('/card',{
    			params: {
			      page: this.page,
			      page_sizes:this.pagetotal,
			      selectclass:this.itemSelect
			    }
    		}).then((respose)=>{
    			this.tableData = respose.data
    		}).catch((error) => {
    			this.$message(error)
    		})
    	},
    	handleSizeChange(val){
    		this.pagetotal = val
    		if(!this.itemSelect)
    			this.getPage();
    		else
    			this.getClassPage();
    	},
    	handleCurrentChange(val){
			this.page = val;
			if(!this.itemSelect)
    			this.getPage();
    		else
    			this.getClassPage();
    	},
    	formatter(row, column){
    		if(row.cardtype!='随从'){
    			return "无";
    		}
    	},

    }
}
</script>
<style lang="scss" scoped="" type="text/css">
.img-box{
	position: absolute;
	z-index: 99999;
	height:300px;
	width: 300px;
}
</style>