<template>
    <div :class="checkClass">
       <div class="row">
           <div class="col-lg-3 col-6">
               <!-- small card -->
               <div class="small-box bg-info">
                   <div class="inner">
                       <h3>1</h3>

                       <p>Library</p>
                   </div>
                   <div class="icon">
                       <i class="fas fa-book-open"></i>
                   </div>
                   <router-link to="/library" class="small-box-footer">
                       More info <i class="fas fa-arrow-circle-right"></i>
                   </router-link>
               </div>
           </div>
           <div class="col-lg-3 col-6">
               <!-- small card -->
               <div class="small-box bg-success">
                   <div class="inner">
                       <h3>2</h3>

                       <p>Category</p>
                   </div>
                   <div class="icon">
                       <i class="fas fa-book-open"></i>
                   </div>
                   <router-link to="/category" class="small-box-footer">
                       More info <i class="fas fa-arrow-circle-right"></i>
                   </router-link>
               </div>
           </div>
           <div class="col-lg-3 col-6">
               <!-- small card -->
               <div class="small-box bg-gray">
                   <div class="inner">
                       <h3>3</h3>

                       <p>Library Sub-Category</p>
                   </div>
                   <div class="icon">
                       <i class="fas fa-book-open"></i>
                   </div>
                   <router-link to="/scategory" class="small-box-footer">
                       More info <i class="fas fa-arrow-circle-right"></i>
                   </router-link>
               </div>
           </div>
           <div class="col-lg-3 col-6">
               <!-- small card -->
               <div class="small-box bg-primary">
                   <div class="inner">
                       <h3>4</h3>

                       <p>Library Transactions</p>
                   </div>
                   <div class="icon">
                       <i class="fas fa-book-open"></i>
                   </div>
                   <router-link to="/lib_transactions" class="small-box-footer">
                       More info <i class="fas fa-arrow-circle-right"></i>
                   </router-link>
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-lg-3 col-6">
               <!-- small card -->
               <div class="small-box bg-warning">
                   <div class="inner">
                       <h3>5</h3>

                       <p>Define Library</p>
                   </div>
                   <div class="icon">
                       <i class="fas fa-book-open"></i>
                   </div>
                   <router-link to="/definelib" class="small-box-footer">
                       More info <i class="fas fa-arrow-circle-right"></i>
                   </router-link>
               </div>
           </div>
       </div>
            <!-- /.info-box -->
        </div>
</template>

<script>
    export default {

        data()
        {
            return {
                name: "LibCardsComponent",
                checkClass:'container d-none'
            }
        },
        mounted()
        {
            axios.get('api/uservals/card_check')
                .then(response=>{
                    if (response.data===1)
                    {
                        this.checkClass='container d-block';
                    }
                    else
                    {
                        this.checkClass='container d-none';
                    }
                })
                .catch(error=>console.log(error));
        },
    }
</script>

<style scoped>

</style>
