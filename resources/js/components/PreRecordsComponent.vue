<template>
    <div class="container">
        <div class="card pb-0 mb-1">
            <div class="card-header text-info text-bold">
                Previous Record Data
                <div :class="secClass" id="download"><a :href="fileName" target="_blank" @click="linkClick"><i class="fas fa-download fa-3x"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-2">
                        <label for="ctype">Training Type</label>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <select class="form-control" id="ctype" v-model="trainingtype">
                                <option :value="cdata.coursetype_id" v-for="cdata in ccourseData">
                                    {{cdata.coursetype_desc}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 text-right">
                        <label for="Training">Training</label>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <select class="form-control" id="training" v-model="training">
                                <option :value="cddata.cid" v-for="cddata in ccourseDet">
                                    {{cddata.cdesc}}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group form-check-inline d-flex flex-row justify-content-around">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="presentation" id="presentation" v-model="filetype" name="customRadio">
                        <label for="presentation" class="custom-control-label">Presentation</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="lecture" id="lecture" v-model="filetype" name="customRadio">
                        <label for="lecture" class="custom-control-label">Lecture</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="video" id="video" v-model="filetype" name="customRadio">
                        <label for="video" class="custom-control-label">Video</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" value="audio" id="audio" v-model="filetype" name="customRadio">
                        <label for="audio" class="custom-control-label">Audio</label>
                    </div>
                </div>
            </div>
        </div>
        <PrevTableComponent :training="combineVal" @onClickDownload="downloadFile"></PrevTableComponent>
    </div>


</template>

<script>
   import PrevTableComponent from "./PrevTableComponent";
   export default {
       components: {PrevTableComponent},
       data(){
         return{
             trainingtype:'',
             training:'',
             combineVal:'',
             ccourseDet:{},
             ccourseData:{},
             fileName: '',
             secClass:'d-none mt-3',
             filetype:''
         }
       },
       watch:{
           filetype:function () {
               if (this.trainingtype==='')
               {
                   alert("Select Training Type First");
               }
               this.combineVal=this.training+'-'+this.trainingtype+'-'+this.filetype;
           },
           trainingtype:function () {
               this.getCourseDetail();
           }
       },
       mounted() {
           this.getcType();
       },
       methods:{

           getCourseDetail()
           {
               axios.get('api/addcourse/definelib-'+this.trainingtype)
                   .then(response=>this.ccourseDet=response.data)
                   .catch(error=>console.log(error));
           },
           getcType() {
               axios.get('api/coursetype/' + 1)
                   .then(response => this.ccourseData = response.data)
                   .catch(error => console.log(error));
           },
           downloadFile: function (value) {
               let path = 'https://tsgportal.ntdc.com.pk/logdata/' + value.toString();
               this.fileName = path;
               this.secClass='d-block mt-3 d-flex justify-content-center animated pulse delay-2s';
           },
           linkClick()
           {
               this.secClass='d-none';
           }
       }
   }
</script>
<style scoped>

</style>
