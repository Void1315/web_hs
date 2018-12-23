<template>
	<div>
		<transition name="el-zoom-in-bottom">
			<el-row v-show="b_card_select">
				<el-col :span="18">
					<el-row>
						<el-col>
							<div>
								<span>限定搜索</span>
								<el-select 
								@change="serachClass"
								v-model="select_class_value" placeholder="请选择">
							    	<el-option
								      v-for="item in class_options"
								      :key="item.value"
								      :label="item.label"
								      :value="item.value">
							    	</el-option>
							  	</el-select>
								<el-button @click="backToClass" type="danger" icon="el-icon-back" circle></el-button>
								<span>返回上一页</span>
							</div>
							
						</el-col>
					</el-row>
					<div class="card-list-box">
						<el-table
					      :data="cardData"
					      @row-dblclick="clickCard"
					      style="width: 100%">
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
						        prop="rarity"
						        label="稀有度"
						        >
					      </el-table-column>
					      <el-table-column
						      prop="classes[0].name"
						      width="120"
						      :formatter="formatterClassName"
						      label="职业名称">
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
						      :formatter="formatterAttack"
						      align="center"
						      sortable
						      label="攻击力">
						    </el-table-column>
						    <el-table-column
						      prop="health"
						      width="110"
						      :formatter="formatterHealth"
						      align="center"
						      sortable
						      label="生命值">
						    </el-table-column>
					    </el-table>
					<el-pagination
				      :current-page="page"
				      :page-size="pagetotal"
				      :page-count="pageSize"
				      :page-sizes="[20, 30, 40, 50]"
				      layout="total, sizes, prev, pager, next, jumper"
				      @size-change="handleSizeChange"
		     		  @current-change="handleCurrentChange"
				      :total="total">
				    </el-pagination>
					</div>
				</el-col>
				<el-col :span="6" class="right-box">
					<div class="select-card-box">
						<div class="class-img-box">
							<img class="select-class-img"  :src="class_img">
						</div>
						<div class="set-name-box">
							<el-input style="width: 50%;" v-model="card_name" placeholder="输入一个帅气的套牌名！" clearable :maxlength="20"></el-input>
						</div>
						<div class="set-list">
							<el-table
							@row-dblclick="removeCard"
						      :data="selectData"
						      :max-height="400"
						      style="width: 100%">
						      <el-table-column
						        prop="name"
						        label="名称"
						        >
						      </el-table-column>
						      <el-table-column
						        prop="size"
						        label="数量"
						        >
						      </el-table-column>
						      <el-table-column
						        prop="rarity"
						        label="稀有度"
						        >
						      </el-table-column>
						    </el-table>
						</div>
						<div class="set-config-box">
							<el-row type="flex" justify="space-around">
								<el-button @click="saveSet" type="success" icon="el-icon-check" circle></el-button>
								<span>
									{{set_size}}/30
								</span>
								<el-button @click="removeSet" v-show="b_remove" type="danger" icon="el-icon-delete" circle></el-button>
							</el-row>
						</div>
					</div>
				</el-col>
			</el-row>
		</transition>
		<div>
			<transition name="el-zoom-in-center">
				<el-row v-show="b_class_select">
					<el-card class="box-card">
						<el-row>
							<el-col :span="8" >
								<div class="class-box" >
									<img class="class-img" v-on:click="selectClass(2)" src="/image/德鲁伊.jpg">
								</div>
							</el-col>
							<el-col :span="8" >
								<div class="class-box">
									<img class="class-img" v-on:click="selectClass(3)" src="/image/法师.jpg">
								</div>
							</el-col>
							<el-col :span="8" >
								<div class="class-box">
									<img class="class-img" v-on:click="selectClass(11)" src="/image/猎人.jpg">
								</div>
							</el-col>
						</el-row>
						<el-row>
							<el-col :span="8" >
								<div class="class-box" >
									<img class="class-img" v-on:click="selectClass(5)" src="/image/牧师.jpg">
								</div>
							</el-col>
							<el-col :span="8" >
								<div class="class-box">
									<img class="class-img" v-on:click="selectClass(6)" src="/image/潜行者.jpg">
								</div>
							</el-col>
							<el-col :span="8" >
								<div class="class-box">
									<img class="class-img" v-on:click="selectClass(7)" src="/image/萨满.jpg">
								</div>
							</el-col>
						</el-row>
						<el-row>
							<el-col :span="8" >
								<div class="class-box" >
									<img class="class-img" v-on:click="selectClass(4)" src="/image/圣骑士.jpg">
								</div>
							</el-col>
							<el-col :span="8" >
								<div class="class-box">
									<img class="class-img" v-on:click="selectClass(8)" src="/image/术士.jpg">
								</div>
							</el-col>
							<el-col :span="8" >
								<div class="class-box">
									<img class="class-img" v-on:click="selectClass(9)" src="/image/战士.jpg">
								</div>
							</el-col>
						</el-row>
					</el-card>
				</el-row>
			</transition>
		</div>
		<transition name="el-zoom-in-center">
			<div v-show="b_myCard">
				<div class="mycard-box">
					<div class="mycard-item" v-for="item in carditems" @click="cilckSet(item.id,item.code,item.name,item.class_id)">
						<img :src="item.img" class="mycard-img">
						<span class="mycard-title">{{item.name}}</span>
					</div>
					<div>
						<el-button type="primary" icon="el-icon-plus" circle @click="addSet"></el-button>
					</div>
				</div>
			</div>
		</transition>
		
	</div>
</template>
<script type="text/javascript">
export default {
	data(){
		return{
			page:1,
	      	total:0,
	      	pagetotal:10,
	      	pageSize:0,

	      	carditems:[],
	      	b_myCard:true,
	      	set_id:0,
	      	b_setUpdata:false,//是否为更新模式
	      	b_remove:true,
	      	class_model_id:0,
	      	class_options: [{
	          value: '10',
	          label: '中立'
	        }, {
	          value: '0',
	          label: '0'
	        }],
	        select_class_value:0,
	      	card_name:"自定义卡组",
	      	set_size:0,
			select_class_id : 0,
			class_img:"",
			b_card_select:false,
			b_select:false,
			b_class_select:false,
			cardData: [],
			selectData:[],
	        value: '',
	        input:"",
	        code:'',
		}
	},
	mounted() {
        this.getMyCardSet()
    },
    methods:{
    	selectClass(class_id){
    		this.class_options[1].value = class_id
    		this.class_options[1].label = this.getClassName(class_id)
    		this.select_class_value = this.class_options[1].label
    		this.select_class_id = class_id;
    		this.b_class_select = false;
    		this.b_card_select = true;
    		this.class_img = this.getClassImg(class_id);
    		this.getClassCard(class_id);
    		this.class_model_id = class_id;
    	},
    	getClassImg(class_id){
    		var root_path = "/image/";
    		var arr_class = {};
    		arr_class["2"] = "德鲁伊.jpg"
    		arr_class["3"] = "法师.jpg"
    		arr_class["4"] = "圣骑士.jpg"
    		arr_class["5"] = "牧师.jpg"
    		arr_class["6"] = "潜行者.jpg"
    		arr_class["7"] = "萨满.jpg"
    		arr_class["8"] = "术士.jpg"
    		arr_class["9"] = "战士.jpg"
    		arr_class["11"] = "猎人.jpg"
    		return root_path+arr_class[class_id];
    	},
    	getClassName(class_id){
    		var arr_class = {};
    		arr_class["2"] = "德鲁伊"
    		arr_class["3"] = "法师"
    		arr_class["4"] = "圣骑士"
    		arr_class["5"] = "牧师"
    		arr_class["6"] = "潜行者"
    		arr_class["8"] = "术士"
    		arr_class["9"] = "战士"
    		arr_class["11"] = "猎人"
    		return arr_class[class_id];
    	},
    	backToClass(){
    		this.$confirm('是否返回？, 此操作将会丢失未保存数据！', '提示', {
	          confirmButtonText: '确定',
	          cancelButtonText: '取消',
	          type: 'warning'
	        }).then(() => {
	          	this.b_class_select = true;
	    		this.b_card_select = false;
	    		this.selectData = []
	    		this.set_size = 0
	    		this.card_name = '自定义卡组'
	    		this.b_setUpdata = false;
	        }).catch(() => {
	                
	        });
    		
    	},
    	getClassCard(class_id){//ajax获得卡牌信息
    		this.$axios.post('/get/class/card',{
    			class_id:class_id,
    			page:this.page,
    			page_sizes:this.pagetotal,
    		}).then((respose) =>{
    			this.cardData = respose.data.data;
    			this.total = respose.data.total;
    		}).catch((error) =>{
    			this.$message.error("出错了！"+error)
    		})
    	},
    	formatterClassName(row, column){
    		return this.getClassName(this.select_class_id);
    	},
    	formatterAttack(row, column){
    		if(row.cardtype!='随从'){
    			return "无";
    		}
    		else{
    			return row.attack
    		}
    	},
    	formatterHealth(row, column){
    		if(row.cardtype!='随从'){
    			return "无";
    		}
    		else{
    			return row.health
    		}
    	},
    	handleSizeChange(val){
    		this.pagetotal = val
    		this.getClassCard(this.class_model_id)
    	},
    	handleCurrentChange(val){
			this.page = val;
			this.getClassCard(this.class_model_id)
    	},
    	clickCard(row, column, cell, event){
    		if(this.set_size>=30){
    			this.$message.error("最多30张牌!")
    			return;
    		}
    		if(row.size){
    			if(row.rarity == "传说"){
    				this.$message.warning("传说牌只能添加一张")
    				return;
    			}
    			if(row.size == 2){
    				this.$message.warning("同一张牌最多添加两张")
    				return;
    			}
    			row.size = 2;
    			this.selectData.push(row)
    			this.set_size++;
    			this.selectData.pop()
    		}
    		else{
    			row.size = 1; 
    			this.selectData.push(row)
    			this.set_size++;
    		}
    	},
    	getIndex(arr_list,row){
    		for(var i=0;i<arr_list.length;i++){
    			if(arr_list[i].name == row.name)
    				return i
    		}
    		return -1;
    	},
    	removeCard(row, column, cell, event){
    		if(row.size == 1){
    			var index = this.getIndex(this.selectData,row)
    			this.selectData.splice(index,1);
    			this.set_size--
    		}else if(row.size == 2){
    			row.size--;
    			this.set_size--
    		}else{
    			this.$message.error("出现了错误！")
    		}
    		this.selectData.push(row)
			this.selectData.pop()
    	},
    	serachClass(class_id){
    		this.class_model_id = class_id
    		this.getClassCard(class_id)
    	},
    	getCode(arr_list){
    		var code = ""
    		for(var i=0;i<arr_list.length;i++){
    			code+=arr_list[i].id + ","
    			if(arr_list[i].size == 2){
    				code+=arr_list[i].id + ","
    			}
    		}
    		return code;
    	},
    	getIndexId(arr_list,id){
			for(var i=0;i<arr_list.length;i++){
    			if(arr_list[i].id == id)
    				return i
    		}
    		return -1;
    	},
    	getList(code){
    		var id_list = code.split(',')
    		id_list.splice(id_list.length-1,1);
			this.$axios.post('/get/card/arrid',{
				arr_id:id_list
			}).then((respose) => {
				for(var i=0;i<id_list.length;i++){
					var index = this.getIndexId(respose.data,id_list[i])
					if(respose.data[index].size)
						respose.data[index].size = 2;
					else
						respose.data[index].size = 1
					
				}
				this.selectData = respose.data;
			}).catch((error) => {
				this.$message.error("出错了！请刷新")
				console.log(error)
			})
    		
    	},
    	saveSet(){
    		let code = this.getCode(this.selectData) 
    		if(this.b_setUpdata){//更新模式
    			this.$confirm('是否更新套牌？', '提示', {
		          confirmButtonText: '确定',
		          cancelButtonText: '取消',
		          type: 'warning'
		        }).then(() => {
		          	this.$axios.post('/updata/set',{
	    				id:this.set_id,
	    				code:code
	    			}).then((respose) =>{
	    				this.$message.success("更新成功！")
	    			}).catch((error)=>{
	    				this.$message.error("出错了！请刷新")
	    			})
		        }).catch(() => {
		                
		        });
    		}else{//保存模式
	    		this.$axios.post('/save/cardset',{
	    			code:code,
	    			class_id:this.select_class_id,
	    			name:this.card_name
	    		}).then((respose) => {
	    			this.$message.success("保存成功！")
	    		}).catch((error) => {
	    			this.$message.error("出错了！请刷新")
	    		})
    		}
    	},
    	getMyCardSet(){
    		this.$axios.get('/get/user/cardset').then((respose) => {
    			console.log(respose)
    			this.carditems = respose.data;
    			for(var i=0;i<this.carditems.length;i++){
    				this.carditems[i].img = this.getClassImg(this.carditems[i].class_id)
    			}
    		})
    	},
    	removeSet(){
    		if(this.b_setUpdata){//删除
    			this.$confirm('是否删除？', '提示', {
		          confirmButtonText: '确定',
		          cancelButtonText: '取消',
		          type: 'warning'
		        }).then(() => {
		          	this.$axios.post('/delete/set',{
	    				id:this.set_id
	    			}).then((respose) =>{
	    				this.$message.success("删除成功！")
	    			}).catch((error)=>{
	    				this.$message.error("出错了！请刷新")
	    			})
		        }).catch(() => {
		                
		        });
    			
    		}else{//清空
    			this.selectData = []
    			this.card_name = '自定义卡组'
    			this.set_size = 0
    		}
    	},
    	cilckSet(id,code,name,class_id){
    		this.set_id = id;
    		this.b_myCard = false
    		this.selectData = this.getList(code)
    		this.selectClass(class_id)
    		console.log(code)
    		this.set_size = 30
    		this.card_name = name;
    		this.b_setUpdata = true;//打开更新模式
    	},
    	addSet(){
    		this.b_myCard = false;
    		this.b_class_select = true;
    	}
    }
}

</script>
<style lang="scss" scoped="" type="text/css">
$shadow-color:rgba(26, 26, 26, 0.1);
.set-title{
	font-family: "PingFang SC";
	font-size: 20px;
}
.set-name-box{
	display: flex;
	justify-content: center;
}
.class-img{
    width: 200px;
    height: auto;
}
.class-img-box{
    display: inline-flex;
    justify-content: center;
}
.select-class-img{
	width: 50%;
    height: 50%;
}
.right-box{
    border-left-width: 1px;
    border-left-style: solid;
    border-color: $shadow-color;
}
.mycard-img{
    width: 150px;
    max-height: 110px;
    height: auto;
}
.mycard-item{
	display: inline-flex;
    flex-direction: column;
    align-items: center;
    margin: 0 20px;
    cursor: pointer;
}
.mycard-box{
	display: flex;
}
.mycard-title{
    margin-top: 5px;
    font-family: cursive;
    font-size: 22px;
    font-weight: bold;
}

</style>