<template>
    <div class="card card-deck">
        <div class="card-header" style="font-weight:bold"><span class="glyphicon glyphicon-align-justify"></span> All Resources</div>
        <div class="row">
            <div class="search-wrapper card-heading col-sm-6">
                <input class="form-control" type="text" v-model="searchQuery" placeholder="Search" />
            </div>
            <div class="search-wrapper card-heading col-sm-6">
                <input class="form-control" type="text" v-model="searchQuerySecond" placeholder="ID" />
            </div>
        </div>
        <div class="panel-body" style="max-height: 400px;overflow-y: scroll;">
            <table v-if="resources.length" class="table">
                <thead>
                <tr>
                    <th>Resource</th>
                    <th>Id</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in filteredResources">
                    <td><a v-bind:href="item.uri" target="_blank">{{item.title}}</a></td>
                    <td><a  target="_blank">{{item.category}}</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                searchQuery:'',
                searchQuerySecond:'',
                resources:[
                    {title:"aaa",uri:"aaaa.com",category:"a",icon:null},
                    {title:"add",uri:"aaaa.com",category:"a",icon:null},
                    {title:"aff",uri:"aaaa.com",category:"a",icon:null},
                    {title:"bbb",uri:"bbbb.com",category:"b",icon:null},
                    {title:"bdd",uri:"bbbb.com",category:"b",icon:null},
                    {title:"bsb",uri:"bbbb.com",category:"b",icon:null},
                    {title:"ccc",uri:"cccc.com",category:"c",icon:null},
                    {title:"ddd",uri:"dddd.com",category:"d",icon:null}
                ]
            };
        },
        computed: {
            filteredResources (){
                if(this.searchQuery){
                    return this.resources.filter((item)=>{
                        return item.title.startsWith(this.searchQuery);
                    })
                }
                else if (this.searchQuerySecond)
                {
                    return this.resources.filter((item)=>{
                        return item.title.startsWith(this.searchQuerySecond);
                    })
                }
                else{
                    return this.resources;
                }
            }
        }
    }
</script>

<style scoped>

</style>
