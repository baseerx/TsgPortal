<template>
<div class="container">
    <div class="form-group">
        <label for="questionone">Are there any thoughts you'd like to share? (Comments)*</label>
        <textarea class="form-control" rows="5" id="questionone" v-model="form.questionOne"></textarea>
    </div>

</div>
</template>

<script>
    export default {
       props:['feedsub','pid'],
        data(){
            return{
                 form:new Form({
                     questionOne:'',
                     questionTwo:'',
                     questionThree:'',
                     lectureid:''
                 }),

            }
        },
        watch:{
            feedsub:function()
            {
                 this.submitSubFeed();

            }
        },
        methods:{
           submitSubFeed()
           {
               this.form.lectureid=this.pid;
             this.form.post('https://tsgportal.ntdc.com.pk/api/feedsub')
                   .then(response=>{
                       swal('Thank You!!','Your FeedBack Submitted Successfully..','success');
                       this.$router.push('/dashboard');
                   })
                   .catch(error=>console.log(error));
           }
        }
    }
</script>

<style scoped>

</style>
