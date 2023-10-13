<template>

    <div class="row">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">
                    <h3 class="text-info" v-once v-text="name"></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8 offset-2">
                            <form @submit="createMenu" id="mainForm">
                                <div class="row">
                                    <div class="col-2 offset-1"><label for="main_menu">Description:</label></div>
                                    <div class="col-8">
                                        <div class="input-group form-group">
                                            <input autocomplete="off" class="form-control w-50 ml-auto" id="main_menu"
                                                   name="main_menu" placeholder="Enter.." required type="text"
                                                   v-model="menu">
                                        </div>
                                    </div>
                                </div>
                              <div class="row">
                                  <div class="col-2 offset-1"><label for="menu_url">URL:</label></div>
                                  <div class="col-8"> <div class="input-group form-group">

                                      <input autocomplete="off" class="form-control w-75 ml-auto" id="menu_url"
                                             name="main_menu" placeholder="Enter URL" required type="text"
                                             v-model="menuUrl">
                                  </div></div>
                              </div>

                                <div class="input-group form-group justify-content-center">
                                    <div class="input-group-append">
                                        <button class="btn btn-navbar text-primary" type="submit">
                                            <i class="fas fa-2x fa-plus-circle"></i>
                                        </button>
                                        <button :value="menu_id" @click="deleteMenu"
                                                class="btn btn-navbar text-delete text-danger" type="button">
                                            <i class="fas fa-2x fa-trash"></i>
                                        </button>
                                        <button @click="updateMenu" class="btn btn-navbar text-delete text-success"
                                                type="button">
                                            <i class="fas fa-2x fa-pen"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-hover">
                                <tr class="text-center">
                                    <th>Sr.</th>
                                    <th>Main Menu</th>
                                    <th>Menu Url</th>
                                    <th></th>
                                </tr>
                                <tr :id="'row'+records.mmenuId" class="text-center"
                                    v-for="(records,index) in records.data">
                                    <td>{{++index}}</td>
                                    <td :id="'td'+records.mmenuId">{{records.mmenuDesc}}</td>
                                    <td :id="'td1'+records.mmenuId">{{records.mmenuURL}}</td>
                                    <td>
                                        <a @click="selectRecord(records.mmenuId)" class="pl-3">
                                            <i class="fas fa-lg fa-pen text-info">

                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                <pagination :data="records" @pagination-change-page="getResults"
                                            class="pagination justify-content-center"></pagination>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    Tsg Portal @NTDC
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                menu: '',
                name: "Add Main Menu",
                records: {},
                menu_id: '',
                menuUrl: '',

            }
        },
        mounted() {
            Fire.$on('updateRecords', () => {
                this.getResults();
            });
            this.getResults();

        },
        methods:
            {
                createMenu() {

                    axios.post('api/mmain', {mname: this.menu, murl: this.menuUrl})
                        .then(response => {
                            // swal("Congratulations!","Menu name added successfully..","success");
                        })
                        .catch(error => {
                            swal("Notice!", "Menu name does not added..", "error");
                        });

                    this.form.reset();
                },
                selectRecord(id) {
                    var tdVal = $("#td" + id).text();
                    var url = $("#td1" + id).text();
                    this.menu = tdVal;
                    this.menuUrl = url;
                    this.menu_id = id;
                },
                deleteMenu() {

                    axios.delete('api/mmain/' + this.menu_id)
                        .then(response => {
                            swal("Notice!", "Record Deleted Successfully", "error")
                                .then((value) => {
                                    Fire.$emit('updateRecords');
                                });
                        })
                        .catch(error => {
                            swal("Notice!", "This link can't be delete as it is linked further..", "error");
                        });
                },
                updateMenu() {
                    axios.put('api/mmain/' + this.menu_id, {title: this.menu, murl: this.menuUrl})
                        .then(response => {
                            swal("Congratulations!", "Your record updated successfully..", "success")
                                .then((value) => {
                                    Fire.$emit('updateRecords');
                                });


                        })
                        .catch(error => {
                            swal("Notice!", "Some sort of error occured", "error");
                        });
                },
                getResults(page) {
                    if (typeof page === 'undefined') {
                        page = 1;
                    }
                    axios.get('api/mmain?page=' + page)
                        .then(response => this.records = response.data)
                        .catch(error => {
                            swal("Notice!", "Data is not loading..", "error");
                        })
                }
            }
    }
</script>

<style scoped>

</style>
