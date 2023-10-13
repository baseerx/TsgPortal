<template>
    <div :class="checkClass">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info mt-2">
                    <div class="inner">
                        <h3>1</h3>
                        <p class="font-weight-bolder">Users List</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <router-link to="/users" class="small-box-footer">
                        Show Users <i class="fas fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success mt-2">
                    <div class="inner">
                        <h3>2</h3>
                        <p class="font-weight-bolder">Users Rights</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <router-link to="/user_right" class="small-box-footer">
                        Show Rights <i class="fas fa-arrow-circle-right"></i>
                    </router-link>
                </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {

        data()
        {
            return {
                name: "CourseCardsComponent",
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
