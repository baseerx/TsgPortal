<template>
    <div class="card w-100">
        <div class="card-body">
            <h5 class="card-title">{{ this.name }}</h5>
            <br>
            <div class="form-group">
                <label for="feedbackTxtDetail">Your FeedBack..</label>
                <textarea class="form-control" v-model="feedbk" id="feedbackTxtDetail" rows="3"></textarea>
            </div>
            <div class="d-flex justify-content-center">
                <button @click="submitFeedbackTxt" class="btn btn-success btn-sm mb-2">Submit</button>
            </div>
        </div>
    </div>

</template>

<script>
export default {
   data(){
       return{
           name: "Write your feedback in detail..",
           feedbk:""
       }
   },
    methods:{
        submitFeedbackTxt(){
            axios.post('api/fdtxt',{feedbk:this.feedbk})
            .then(response=>{
                this.feedbk="";
            })
            .catch(error=>console.log(error))
        }
    }
}
</script>

<style scoped>

</style>
