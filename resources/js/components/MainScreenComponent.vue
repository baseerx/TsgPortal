<template>
    <div>
        <v-app>
            <v-container fluid>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{this.name}}</h4>
                    </div>
                    <div class="card-body">
                        <v-form @submit.prevent="submitRecord" id="check-login-form" ref="form">
                            <v-container>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="10" v-if="fileupload">
                                        <label for="file">Excel File</label>
                                        <input
                                            @change="pickFile"
                                            class="form-control-file h-50"
                                            id="file"
                                            name="file"
                                            type="file"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-switch class="mx-2" label="fileupload" v-model="fileupload"></v-switch>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="name">Name</label>
                                        <select class="form-control-sm h-2 float-right" id="exname" name="exname">
                                            <option :key="i" :value="n" v-for="(n,i) in nameUpper">{{n}}</option>
                                        </select>
                                        <select class="form-control h-50" id="name" v-model="form.uid">
                                            <option :key="i" :value="n.id" v-for="(n,i) in getuserName"
                                                    v-text="n.name"></option>
                                        </select>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label>Record Date</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.datetime"
                                        >
                                            <option value=moment(Date.now()).format("Y-M-D")>Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in recUpper">{{n}}</option>
                                        </select>
                                        <date-pick
                                            :format="'YYYY-MM-DD'"
                                            :pickTime="true"
                                            class="form-control h-50"
                                            v-model="form.datetime"
                                        ></date-pick>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="assetno">Asset no</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.assetno"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in assetUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="assetno"
                                            name="assetno"
                                            type="text"
                                            v-model="form.assetno"
                                        />
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label>Legacy asset no</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.lassetno"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in lassetUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            type="text"
                                            v-model="form.lassetno"
                                        />
                                        <div class="invalid-feedback">A valid Text is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="tangorintang">Tangible/In-Tangible<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            id="tangrintang"
                                            name="tangrintang"
                                            v-model="form.tangorintang"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in ttUpper">{{n}}</option>
                                        </select>
                                        <select
                                            id="tangorintang"
                                            name="tangorintang"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validText(form.tangorintang) && tangInTangBlured}"
                                            v-model="form.tangorintang"
                                            v-on:blur="tangInTangBlured = true"
                                        >
                                            <option value="">Select</option>
                                            <option value="tangible">Tangible</option>
                                            <option value="intangible">InTangible</option>
                                        </select>
                                        <div class="invalid-feedback">Selection of any option is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="companycode">Company Code<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            id="ccode"
                                            name="ccode"
                                            v-model="form.companycode"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in ccodeUpper">{{n}}</option>
                                        </select>
                                        <input
                                            id="companycode"
                                            name="companycode"
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validText(form.companycode) && companycodeBlured}"
                                            v-model="form.companycode"
                                            v-on:blur="companycodeBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Text is required</div>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="assettype">Document Type</label>
                                        <select
                                            class="form-control-sm h-50 h-2 float-right"
                                            id="doctype"
                                            name="doctype"
                                            v-model="form.documenttype"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in documenttypeUpper">{{n}}
                                            </option>
                                        </select>
                                        <input
                                            id="documenttype"
                                            name="documenttype"
                                            required
                                            type="text"
                                            class="form-control h-50"
                                            v-model="form.documenttype"
                                        />
                                        <div class="invalid-feedback">A valid Text is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="assettype">Doc Ref</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            id="docref"
                                            name="docref"
                                            v-model="form.documentref"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in documentrefUpper">{{n}}
                                            </option>
                                        </select>
                                        <input
                                            id="documentref"
                                            name="documentref"
                                            required
                                            type="text"
                                            class="form-control h-50"
                                            v-model="form.documentref"
                                        />
                                        <div class="invalid-feedback">A valid Text is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label>Doc Date</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.docdate"
                                        >
                                            <option value=moment(Date.now()).format("Y-M-D")>Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in docdateUpper">{{n}}</option>
                                        </select>
                                        <date-pick
                                            :format="'YYYY-MM-DD'"
                                            :pickTime="true"
                                            class="form-control h-50"
                                            v-model="form.docdate"
                                        ></date-pick>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="assettype">Asset Type<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            id="assttype"
                                            name="assttype"
                                            v-model="form.assettype"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in asstypeUpper">{{n}}</option>
                                        </select>
                                        <input
                                            id="assettype"
                                            name="assettype"
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validText(form.assettype) && assettypeBlured}"
                                            v-model="form.assettype"
                                            v-on:blur="assettypeBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Text is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label>Main asset</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.mainasset"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in mainassetUpper">{{n}}</option>
                                        </select>
                                        <input
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validText(form.mainasset) && mainassetBlured}"
                                            v-model="form.mainasset"
                                            v-on:blur="mainassetBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Text is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label>Measurement Unit<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.mesrunit"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in mesrunitUpper">{{n}}</option>
                                        </select>
                                        <input
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validText(form.mesrunit) && mesrunitBlured}"
                                            v-model="form.mesrunit"
                                            v-on:blur="mesrunitBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Text is required</div>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="units">Units<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.units"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in unitsUpper">{{n}}</option>
                                        </select>
                                        <input
                                            id="units"
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validNumber(form.units) && unitsBlured}"
                                            v-model="form.units"
                                            v-on:blur="unitsBlured = true"
                                        />
                                        <div class="invalid-feedback">Numeric value is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="inuse">In use</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.inuse"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in inuseUpper">{{n}}</option>
                                        </select>
                                        <select class="form-control h-50" id="inuse" name="inuse" v-model="form.inuse">
                                            <option value="">Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="physical_inventory">Physical inventory</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.inphyicalinv"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in inphysicalUpper">{{n}}</option>
                                        </select>
                                        <select
                                            class="form-control h-50"
                                            id="physical_inventory"
                                            name="physical_inventory"
                                            required
                                            v-model="form.inphyicalinv"
                                        >
                                            <option value="">Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="15">
                                        <label for="ddesc">Detail Description<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 w-50 text-right"
                                            v-model="form.detaildesc"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in ddescUpper"><small>{{n}}</small></option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="ddesc"
                                            type="text"
                                            v-bind:class="{'form-control':true, 'is-invalid' : !validText(form.detaildesc) && detaildescBlured}"
                                            v-model="form.detaildesc"
                                            v-on:blur="detaildescBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Text is required</div>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="assettagno">Asset tag no</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.assettagno"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in assettnoUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="assettagno"
                                            type="text"
                                            v-model="form.assettagno"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="own_leased">Owned|Leased</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.ownedorleased"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in ownedrUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="own_leased"
                                            type="text"
                                            v-model="form.ownedorleased"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="manuf">Manufacturer</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.manufacturer"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in manfUpper">{{n}}</option>
                                        </select>
                                        <select
                                            class="form-control h-50"
                                            id="manuf"
                                            name="manuf"
                                            v-model="form.manufacturer"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="m.mfid" v-for="(m,i) in manufData"
                                                    v-text="m.mname"></option>
                                        </select>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="massetno">Manfature asset no</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.assetsno"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in manfassUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="massetno"
                                            type="text"
                                            v-model="form.assetsno"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="indicator">Indicator</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.indicator"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in indicatorUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="indicator"
                                            type="text"
                                            v-model="form.indicator"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="c_of_origin">Country of origin</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.countryoforigin"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in coriginUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="c_of_origin"
                                            name="c_of_origin"
                                            type="text"
                                            v-model="form.countryoforigin"
                                        />
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="12">
                                        <label for="wdetails">Warranty Details</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.warrentydetails"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in wdetailsUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="wdetails"
                                            name="wdetails"
                                            type="text"
                                            v-model="form.warrentydetails"
                                        />
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="pno">PO No</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.pono"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in ponoUpper">{{n}}</option>
                                        </select>
                                        <input class="form-control h-50" id="pno" type="text" v-model="form.pono"/>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="location">Location<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.location"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in locationUpper">{{n}}</option>
                                        </select>
                                        <input
                                            id="location"
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validText(form.location) && locationBlured}"
                                            v-model="form.location"
                                            v-on:blur="locationBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Text is required..</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="custodian">Custodian</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.custodian"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in custodianUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="custodian"
                                            type="text"
                                            v-model="form.custodian"
                                        />
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="approved_budget">Approved budget</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.approvedbudget"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in approvedbudgetUpper">{{n}}
                                            </option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="approved_budget"
                                            type="text"
                                            v-model="form.approvedbudget"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="assetcost">Original Cost</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.assetcost"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in assetcostUpper">{{n}}</option>
                                        </select>
                                        <input
                                            id="assetcost"
                                            class="form-control h-50"
                                            type="text"
                                            v-model="form.assetcost"
                                        />
                                        <div class="invalid-feedback">A valid number is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="ccost">Current cost<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.currentcost"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in currentcostUpper">{{n}}</option>
                                        </select>
                                        <input
                                            id="ccost"
                                            name="ccost"
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validNumber(form.currentcost) && currentcostBlured}"
                                            v-model="form.currentcost"
                                            v-on:blur="currentcostBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid number is required</div>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="svalue">Scrap value<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.scrapvalue"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in scrapvalueUpper">{{n}}</option>
                                        </select>
                                        <input
                                            id="svalue"
                                            name="svalue"
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validNumber(form.scrapvalue) && scrapvalueBlured}"
                                            v-model="form.scrapvalue"
                                            v-on:blur="scrapvalueBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid number is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label>Capitalization Date</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.captdate"
                                        >
                                            <option value=moment(Date.now()).format("Y-M-D")>Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in captdateUpper">{{n}}</option>
                                        </select>
                                        <date-pick
                                            :format="'YYYY-MM-DD'"
                                            :pickTime="true"
                                            class="text-bold form-control h-50"
                                            required
                                            v-model="form.captdate"
                                        ></date-pick>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label>Acquisition date</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.acqdate"
                                        >
                                            <option value=moment(Date.now()).format("Y-M-D")>Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in acqdateUpper">{{n}}</option>
                                        </select>
                                        <date-pick
                                            :format="'YYYY-MM-DD'"
                                            :pickTime="true"
                                            :rules="[v => !!v || 'Item is required']"
                                            class="text-bold form-control h-50"
                                            required
                                            v-model="form.acqdate"
                                        ></date-pick>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="ulife">Useful Life<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.usefullife"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in usefullifeUpper">{{n}}</option>
                                        </select>
                                        <input
                                            id="ulife"
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validNumber(form.usefullife) && usefullifeBlured}"
                                            v-model="form.usefullife"
                                            v-on:blur="usefullifeBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Numeric value is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="rlife">Remaining Life</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.remaininglife"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in remaininglifeUpper">{{n}}
                                            </option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="rlife"
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validNumber(form.remaininglife) && remaininglifeBlured}"
                                            v-model="form.remaininglife"
                                            v-on:blur="remaininglifeBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Numeric value is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="dmethod">Depreciation Method<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.depmethod"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in depmethodUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="dmethod"
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validText(form.depmethod) && remaininglifeBlured}"
                                            v-model="form.depmethod"
                                            v-on:blur="depmethodBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Text value is required</div>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="drate">Depreciation rate<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.deprate"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in deprateUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="drate"
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validNumber(form.deprate) && deprateBlured}"
                                            v-model="form.deprate"
                                            v-on:blur="deprateBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Number value is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="depreciation">Depreciation</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.depreciation"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in depreciationUpper">{{n}}
                                            </option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="depreciation"
                                            required
                                            type="text"
                                            v-model="form.depreciation"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="adepreciation">Accum Depreciation</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.accumdep"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in accumdepUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="adepreciation"
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validNumber(form.accumdep) && accumdepBlured}"
                                            v-model="form.accumdep"
                                            v-on:blur="accumdepBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Number value is required</div>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="imp_charges">Impair Charges</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.impcharges"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in impchargesUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="imp_charges"
                                            required
                                            type="text"
                                            v-model="form.impcharges"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="aimp_charges">Account Impair Loses</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.accumimplosses"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in accumimplossesUpper">{{n}}
                                            </option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="aimp_charges"
                                            type="text"
                                            v-model="form.accumimplosses"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="charge_acc">Charge account</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.depchargeacc"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in depchargeaccUpper">{{n}}
                                            </option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="charge_acc"
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validText(form.depchargeacc) && depchargeaccBlured}"
                                            v-model="form.depchargeacc"
                                            v-on:blur="depchargeaccBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Text value is required</div>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="cost_center">Cost center</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.costcenter"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in costcenterUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="cost_center"
                                            type="text"
                                            v-model="form.costcenter"
                                        />
                                        <div class="invalid-feedback">A valid Text value is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label>Revaluation Date</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.revdate"
                                        >
                                            <option value=moment(Date.now()).format("Y-M-D")>Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in revdateUpper">{{n}}</option>
                                        </select>
                                        <date-pick
                                            :format="'YYYY-MM-DD'"
                                            :pickTime="true"
                                            class="form-control h-50"
                                            v-model="form.revdate"
                                        ></date-pick>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="rev_amount">Revalued Amount</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.revamount"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in revamountUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="rev_amount"
                                            required
                                            type="text"
                                            v-model="form.revamount"
                                        />
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="dep_amount">Depreciation Amount</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.deprevamount"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in deprevamountUpper">{{n}}
                                            </option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="dep_amount"
                                            type="text"
                                            v-model="form.deprevamount"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="acc_rev_amount">Account Revalued</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.accdeprevamount"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in accdeprevamountUpper">{{n}}
                                            </option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="acc_rev_amount"
                                            type="text"
                                            v-model="form.accdeprevamount"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label>Retirement Date</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.planretirdate"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in planretirdateUpper">{{n}}
                                            </option>
                                        </select>
                                        <date-pick
                                            :format="'YYYY-MM-DD'"
                                            :pickTime="true"
                                            class="form-control h-50"
                                            v-model="form.planretirdate"
                                        ></date-pick>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="lcomp">Leasing Comp</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.lcompany"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in lcompanyUpper">{{n}}</option>
                                        </select>
                                        <select class="form-control h-50" id="lcomp" v-model="form.lcompany">
                                            <option value="">Select</option>
                                            <option
                                                :key="i"
                                                :value="l.lcid"
                                                v-for="(l,i) in lcompanyData"
                                                v-text="l.name"
                                            ></option>
                                        </select>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="lagreement">Lease agreement</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.lagreementno"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in lagreementnoUpper">{{n}}
                                            </option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="lagreement"
                                            type="text"
                                            v-model="form.lagreementno"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label>Lease agreement date</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.lagreementdate"
                                        >
                                            <option value=moment(Date.now()).format("Y-M-D")>Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in lagreementdateUpper">{{n}}
                                            </option>
                                        </select>
                                        <date-pick
                                            :format="'YYYY-MM-DD'"
                                            :pickTime="true"
                                            class="form-control h-50"
                                            v-model="form.lagreementdate"
                                        ></date-pick>
                                    </v-col>                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label>Lease start date</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.lstartdate"
                                        >
                                            <option value=moment(Date.now()).format("Y-M-D")>Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in lstartdateUpper">{{n}}</option>
                                        </select>
                                        <date-pick
                                            :format="'YYYY-MM-DD'"
                                            :pickTime="true"
                                            class="form-control h-50"
                                            v-model="form.lstartdate"
                                        ></date-pick>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="lease_length">Lease length</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.leaselen"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in leaselenUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="lease_length"
                                            type="text"
                                            v-model="form.leaselen"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="alloc_asset">Asset allocated to</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.allocatedto"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in allocatedtoUpper">{{n}}</option>
                                        </select>
                                        <input
                                            @focus="openHrisModal()"
                                            class="form-control h-50"
                                            id="alloc_asset"
                                            required
                                            type="text"
                                            v-model="form.allocatedto"
                                        />
                                    </v-col>

                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="4">
                                        <label for="acode">Asset Code<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.assetcode"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in assetcodeUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="acode"
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !notNull(form.assetcode) && assetcodeBlurred}"
                                            v-model="form.assetcode"
                                            v-on:blur="assetcodeBlurred = true"
                                        />
                                        <div class="invalid-feedback">A valid Code is required</div>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label for="acode">Book value</label>
                                        <select
                                            class="form-control-sm h-2 float-right"
                                            v-model="form.bookvalue"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in bookvalueUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50"
                                            id="bookvalue"
                                            type="text"
                                            v-model="form.bookvalue"
                                        />
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label>Purchase asset</label>
                                        <select
                                            class="form-control-sm float-right"
                                            v-model="form.purchasedasset"
                                        >
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in purchasedassetUpper"><small>{{n}}</small>
                                            </option>
                                        </select>
                                        <input
                                            required
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validText(form.purchasedasset) && purchasedassetBlured}"
                                            v-model="form.purchasedasset"
                                            v-on:blur="purchasedassetBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Text is required</div>
                                    </v-col>
                                </v-row>
                                <v-row class="top-margin">
                                    <v-col cols="12" md="6">
                                        <label>Category<span class="text-danger">*</span></label>
                                        <select class="form-control-sm h-2 float-right" v-model="form.category">
                                            <option value="">Select</option>
                                            <option :key="i" :value="n" v-for="(n,i) in catUpper">{{n}}</option>
                                        </select>
                                        <input
                                            class="form-control h-50 w-100"
                                            type="text"
                                            v-bind:class="{'form-control h-50':true, 'is-invalid' : !validText(form.category) && categoryBlured}"
                                            v-model="form.category"
                                            v-on:blur="categoryBlured = true"
                                        />
                                        <div class="invalid-feedback">A valid Text value is required</div>
                                    </v-col>
                                </v-row>
                                <div class="row">
                                    <div class="col-6 offset-5">
                                        <v-btn
                                            color="primary"
                                            form="check-login-form"
                                            large
                                            outlined
                                            type="submit"
                                            v-text="btnName"
                                        ></v-btn>
                                    </div>
                                </div>
                            </v-container>
                            <MainScreenTable :randno="passrandNo" @updaterecord="updateRecord"></MainScreenTable>
                            <template v-if="hrisModalFlag">
                                <HrisModalComponent @allocatedto_field="assignToAllocate"></HrisModalComponent>
                            </template>
                        </v-form>
                    </div>
                </div>
            </v-container>
        </v-app>
    </div>
</template>

<script>
import DatePick from "vue-date-pick";
import "vue-date-pick/dist/vueDatePick.css";
import MainScreenTable from "./MainScreenTable";
import HrisModalComponent from "./HrisModalComponent";
import XLSX from "xlsx";
import * as df from 'dateformat';
import moment from 'moment'

export default {
    components: {
        DatePick,
        MainScreenTable,
        HrisModalComponent
    },
    data() {
        return {
            form: new Form({
                uid: 0,
                datetime: moment(Date.now()).format("Y-M-D"),
                assetno: "",
                lassetno: "",
                tangorintang: "",
                companycode: "",
                documenttype: "",
                documentref: "",
                docdate: moment(Date.now()).format("Y-M-D"),
                purchasedasset: "",
                assettype: "",
                mainasset: "",
                mesrunit: "",
                bookvalue: "",
                category: "",
                units: "",
                inuse: "",
                inphyicalinv: "",
                detaildesc: "",
                assettagno: "",
                ownedorleased: "",
                manufacturer: "",
                assetsno: "",
                indicator: "",
                countryoforigin: "",
                warrentydetails: "",
                pono: "",
                location: "",
                custodian: "",
                approvedbudget: "",
                assetcost: "",
                currentcost: "",
                scrapvalue: "",
                captdate: moment(Date.now()).format("Y-M-D"),
                acqdate: moment(Date.now()).format("Y-M-D"),
                usefullife: "",
                remaininglife: 0,
                depmethod: "",
                deprate: "",
                depreciation: "",
                accumdep: 0,
                impcharges: 0,
                accumimplosses: 0,
                depchargeacc: 0,
                costcenter: "",
                revdate: moment(Date.now()).format("Y-M-D"),
                revamount: "",
                deprevamount: "",
                accdeprevamount: "",
                planretirdate: moment(Date.now()).format("Y-M-D"),
                lcompany: "",
                lagreementno: "",
                lagreementdate: moment(Date.now()).format("Y-M-D"),
                lstartdate: moment(Date.now()).format("Y-M-D"),
                leaselen: "",
                allocatedto: "",
                assetcode: ""
            }),
            name: "Entry Screen..",
            fileupload: false,
            textBlured: false,
            tangInTangBlured: false,
            companycodeBlured: false,
            documenttypeBlured: false,
            documentrefBlured: false,
            docdateBlured: false,
            purchasedassetBlured: false,
            assettypeBlured: false,
            mainassetBlured: false,
            mesrunitBlured: false,
            categoryBlured: false,
            unitsBlured: false,
            detaildescBlured: false,
            locationBlured: false,
            currentcostBlured: false,
            scrapvalueBlured: false,
            usefullifeBlured: false,
            remaininglifeBlured: false,
            depmethodBlured: false,
            deprateBlured: false,
            accumdepBlured: false,
            depchargeaccBlured: false,
            assetcodeBlurred: false,
            passrandNo: 0,
            hrisModalFlag: false,
            btnName: "Submit",
            valid: false,
            getuserName: [],
            manufData: [],
            specific_row: 2,
            classificationData: [],
            categoryData: [],
            lcompanyData: [],
            nameUpper: [],
            recUpper: [],
            assetUpper: [],
            lassetUpper: [],
            ttUpper: [],
            ccodeUpper: [],
            documenttypeUpper: [],
            documentrefUpper: [],
            docdateUpper: [],
            purchasedassetUpper: [],
            asstypeUpper: [],
            mainassetUpper: [],
            mesrunitUpper: [],
            bookvalueUpper: [],
            catUpper: [],
            unitsUpper: [],
            inuseUpper: [],
            inphysicalUpper: [],
            ddescUpper: [],
            assettnoUpper: [],
            ownedrUpper: [],
            manfUpper: [],
            manfassUpper: [],
            indicatorUpper: [],
            coriginUpper: [],
            wdetailsUpper: [],
            ponoUpper: [],
            locationUpper: [],
            custodianUpper: [],
            approvedbudgetUpper: [],
            assetcostUpper: [],
            currentcostUpper: [],
            scrapvalueUpper: [],
            captdateUpper: [],
            acqdateUpper: [],
            usefullifeUpper: [],
            remaininglifeUpper: [],
            depmethodUpper: [],
            deprateUpper: [],
            depreciationUpper: [],
            accumdepUpper: [],
            impchargesUpper: [],
            accumimplossesUpper: [],
            depchargeaccUpper: [],
            costcenterUpper: [],
            revdateUpper: [],
            revamountUpper: [],
            deprevamountUpper: [],
            accdeprevamountUpper: [],
            planretirdateUpper: [],
            lcompanyUpper: [],
            lagreementnoUpper: [],
            lagreementdateUpper: [],
            lstartdateUpper: [],
            leaselenUpper: [],
            allocatedtoUpper: [],
            assetcodeUpper: [],
            updateId: 0
        };
    },
    mounted() {
        Fire.$on("updateTable", () => {
            this.passrandNo = Math.random();
        });
        this.getUserData();
        this.getManufData();
        this.getClassifficationData();
        this.getCategoryData();
        this.getLeasingCompData();
    },
    watch: {
        fileupload: function (val) {
            val === true ? this.btnName = "IMPORT" : this.btnName = "SUBMIT";
        }
    },
    methods: {
        validate: function () {
            this.assetcodeBlurred = true;
            this.textBlured = true;
            this.companycodeBlured = true;
            this.tangInTangBlured = true;
            this.assettypeBlured = true;
            this.categoryBlured = true;
            this.unitsBlured = true;
            this.detaildescBlured = true;
            this.locationBlured = true;
            this.currentcostBlured = true;
            this.scrapvalueBlured = true;
            this.usefullifeBlured = true;
            this.remaininglifeBlured = true;
            this.depmethodBlured = true;
            this.deprateBlured = true;
            this.accumdepBlured = true;
            this.mesrunitBlured = true;
            this.depchargeaccBlured = true;

            // alert("depcharge"+this.validText(this.form.depchargeacc));
            // alert("depmethod"+this.validText(this.form.depmethod));
            // alert("tangorintang"+this.validText(this.form.tangorintang));
            // alert("company code"+this.validText(this.form.companycode));
            // alert("assettype"+this.validText(this.form.assettype));
            // alert("category"+this.validText(this.form.category));
            // alert("units"+this.validNumber(this.form.units));
            // alert("detailsdesc"+this.validText(this.form.detaildesc));
            // alert("accumdep"+this.validNumber(this.form.accumdep));
            // alert("mesrunit"+this.validNumber(this.form.mesrunit));
            // alert("deprate"+this.validNumber(this.form.deprate));
            // alert("remaininglife"+this.validNumber(this.form.remaininglife));
            // alert("useful life"+this.validNumber(this.form.usefullife));
            // alert("scrap value"+this.validNumber(this.form.scrapvalue));
            // alert("currentcost"+this.validNumber(this.form.currentcost));
            // alert("assetcode"+this.notNull(this.form.assetcode));
            // alert("location"+this.validText(this.form.location));
            if (
                this.validText(this.form.depchargeacc) &&
                this.validText(this.form.depmethod) &&
                this.validText(this.form.tangorintang) &&
                this.validText(this.form.companycode) &&
                this.validText(this.form.assettype) &&
                this.validText(this.form.category) &&
                this.validNumber(this.form.units) &&
                this.validText(this.form.detaildesc) &&
                this.validNumber(this.form.accumdep) &&
                this.validText(this.form.mesrunit) &&
                this.validNumber(this.form.deprate) &&
                this.validNumber(this.form.remaininglife) &&
                this.validNumber(this.form.usefullife) &&
                this.validNumber(this.form.scrapvalue) &&
                this.validNumber(this.form.currentcost) &&
                this.notNull(this.form.assetcode) &&
                this.validText(this.form.location)
            ) {
                this.valid = true;
            }
        },
        validText(txt) {
            var regText = /[a-zA-Z0-9]+/;
            return regText.test(txt);
        },
        notNull(txt) {
            var regText = /^\s*$/;
            return !regText.test(txt);
        },
        validNumber(num) {
            let reg = /^[0-9]\d*(\.\d+)?$/;
            return reg.test(num);
        },
        validSelectText(txt) {
            var regText = "Select";
            return regText.test(txt);
        },
        getUserData() {
            axios
                .get("api/user/loggedUser")
                .then(response => {
                    this.getuserName = response.data;
                    this.form.uid = this.getuserName[0].id;
                })
                .catch(error => console.log(error));
        },
        getClassifficationData() {
            axios
                .get("api/assetcls/forMainScreen")
                .then(response => {
                    this.classificationData = response.data;
                })
                .catch(error => cosole.log(error));
        },
        getCategoryData() {
            axios
                .get("api/assetcategory/forMainScreen")
                .then(response => {
                    this.categoryData = response.data;
                })
                .catch(error => cosole.log(error));
        },
        getLeasingCompData() {
            axios
                .get("api/leasingcompany/forMainScreen")
                .then(response => {
                    this.lcompanyData = response.data;
                })
                .catch(error => console.log(error));
        },
        submitRecord() {
            this.validate();
            if (this.valid) {
                if (this.updateId > 0) {
                    this.form
                        .put("api/mainscreen/" + this.updateId)
                        .then(response => {
                            Fire.$emit("updateTable");
                            this.btnName = "Submit";
                            this.form.reset();
                            swal(
                                "Congratulations!",
                                "Record updated successfully..",
                                "success"
                            );
                            this.bluredFlagSet();
                        })
                        .catch(error =>
                            swal(
                                "Failed!",
                                "AssetCode is same or somefields are invalid..",
                                "error"
                            )
                        );
                } else {
                      this.form
                        .post("api/mainscreen")
                        .then(response => {
                            this.form.reset();
                            this.bluredFlagSet();
                            Fire.$emit("updateTable");
                            swal(
                                "Congratulations!",
                                "Record Added Successfully..",
                                "success"
                            );
                        })
                        .catch(error =>
                            swal(
                                "Failed!",
                                "AssetCode is same or somefields are invalid..",
                                "error"
                            )
                        );
                }
            }
        },
        bluredFlagSet() {
            this.textBlured = false;
            this.companycodeBlured = false;
            this.tangInTangBlured = false;
            this.assettypeBlured = false;
            this.classificationBlured = false;
            this.categoryBlured = false;
            this.unitsBlured = false;
            this.detaildescBlured = false;
            this.locationBlured = false;
            this.assetcostBlured = false;
            this.currentcostBlured = false;
            this.scrapvalueBlured = false;
            this.usefullifeBlured = false;
            this.mesrunitBlured = false;
            this.remaininglifeBlured = false;
            this.depmethodBlured = false;
            this.deprateBlured = false;
            this.accumdepBlured = false;
            this.depchargeaccBlured = false;
            this.assetcodeBlurred = false;
        },
        getManufData() {
            axios
                .get("api/manufinfo/all")
                .then(response => (this.manufData = response.data))
                .catch(error => console.log(error));
        },
        updateRecord(id) {
            this.updateId = id;
            this.btnName = "Update";
            axios
                .get("api/mainscreen/" + id)
                .then(response => this.form.fill(response.data))
                .catch(error => swal("Failed!", "Record Cant be fetched..", "error"));
        },
        openHrisModal() {
            this.hrisModalFlag = true;
        },
        assignToAllocate(val) {
            this.form.allocatedto = val.name;
        },
        pickFile(e) {
            let selectedFile = e.target.files[0];
            let fileName = e.target.files[0].name;
            let fileExtension = fileName.split(".");
            if (fileExtension[1] == "xlsx") {
                //    XLSX.utils.json_to_sheet(data, 'out.xlsx');
                if (selectedFile) {
                    let fileReader = new FileReader();
                    fileReader.readAsBinaryString(selectedFile);
                    fileReader.onload = event => {
                        let data = event.target.result;
                        // console.log(data);
                        let workbook = XLSX.read(data, {type: "binary",cellDates:true});
                         // console.log(workbook);
                        workbook.SheetNames.forEach(sheet => {

                            let rowObject = XLSX.utils.sheet_to_row_object_array(
                                workbook.Sheets[sheet]
                            );
                            // const workbook = XLSX.read(source, { 'type': type, cellDates: true });
                            if (rowObject[0].__EMPTY_1.toString().includes("Records Update by (Employee Name)")) {
                                for (let index = 2; index < rowObject.length; index++) {

                                    this.nameUpper.indexOf(rowObject[index].__EMPTY_1) === -1
                                        ? this.nameUpper.push(rowObject[index].__EMPTY_1)
                                        : console.log("Name already exists");

                                    let date1=moment.utc(rowObject[index].__EMPTY_2).local().format('YYYY-MM-DD');
                                    date1 = new Date(date1);
                                    date1=date1.setDate(date1.getDate() + 1);
                                    date1=moment.utc(date1).local().format('YYYY-MM-DD');

                                    this.recUpper.indexOf(date1) === -1
                                        ? this.recUpper.push(date1)
                                        : console.log("Record already exists");

                                    this.assetUpper.indexOf(rowObject[index].__EMPTY_3) === -1
                                        ? this.assetUpper.push(rowObject[index].__EMPTY_3)
                                        : console.log("asset already exists");

                                    this.lassetUpper.indexOf(rowObject[index].__EMPTY_4) === -1
                                        ? this.lassetUpper.push(rowObject[index].__EMPTY_4)
                                        : console.log("lasset already exists");

                                    this.ttUpper.indexOf(rowObject[index].__EMPTY_5.toLowerCase().trim()) === -1
                                        ? this.ttUpper.push(rowObject[index].__EMPTY_5.toLowerCase().trim())
                                        : console.log("tangorintang already exists");

                                    this.ccodeUpper.indexOf(rowObject[index].__EMPTY_6) === -1
                                        ? this.ccodeUpper.push(rowObject[index].__EMPTY_6)
                                        : console.log("company code already exists");

                                    this.documenttypeUpper.indexOf(rowObject[index].__EMPTY_7) === -1
                                        ? this.documenttypeUpper.push(rowObject[index].__EMPTY_7)
                                        : console.log("documenttype already exists");

                                    this.documentrefUpper.indexOf(rowObject[index].__EMPTY_8) === -1
                                        ? this.documentrefUpper.push(rowObject[index].__EMPTY_8)
                                        : console.log("documentref already exists");
                                    console.log(rowObject[index].__EMPTY_9);
                                    let date2=moment.utc(rowObject[index].__EMPTY_9).local().format('YYYY-MM-DD HH:MM:SS');
                                    date2 = new Date(date2);
                                    date2=date2.setDate(date2.getDate() + 1);
                                    date2=moment.utc(date2).local().format('YYYY-MM-DD');
                                    this.docdateUpper.indexOf(date2) === -1
                                        ? this.docdateUpper.push(date2)
                                        : console.log("document date already exists");

                                    this.purchasedassetUpper.indexOf(rowObject[index].__EMPTY_10) === -1
                                        ? this.purchasedassetUpper.push(rowObject[index].__EMPTY_10)
                                        : console.log("purchase asset already exists");

                                    this.asstypeUpper.indexOf(rowObject[index].__EMPTY_11) === -1
                                        ? this.asstypeUpper.push(rowObject[index].__EMPTY_11)
                                        : console.log("asset type already exists");

                                    this.catUpper.indexOf(rowObject[index].__EMPTY_12) === -1
                                        ? this.catUpper.push(rowObject[index].__EMPTY_12)
                                        : console.log("category type already exists")

                                    this.mainassetUpper.indexOf(rowObject[index].__EMPTY_13) === -1
                                        ? this.mainassetUpper.push(rowObject[index].__EMPTY_13)
                                        : console.log("main asset already exists");

                                    this.mesrunitUpper.indexOf(rowObject[index].__EMPTY_14) === -1
                                        ? this.mesrunitUpper.push(rowObject[index].__EMPTY_14)
                                        : console.log("main asset already exists");

                                    this.unitsUpper.indexOf(rowObject[index].__EMPTY_15) === -1
                                        ? this.unitsUpper.push(rowObject[index].__EMPTY_15)
                                        : console.log("units upper already exists");

                                    this.inuseUpper.indexOf(rowObject[index].__EMPTY_16) === -1
                                        ? this.inuseUpper.push(rowObject[index].__EMPTY_16)
                                        : console.log("in use already exists");

                                    this.inphysicalUpper.indexOf(rowObject[index].__EMPTY_17) === -1
                                        ? this.inphysicalUpper.push(rowObject[index].__EMPTY_17)
                                        : console.log("In physical already exists");

                                    this.ddescUpper.indexOf(rowObject[index].__EMPTY_18) === -1
                                        ? this.ddescUpper.push(rowObject[index].__EMPTY_18)
                                        : console.log("detail desc already exists");

                                    this.assettnoUpper.indexOf(rowObject[index].__EMPTY_19) === -1
                                        ? this.assettnoUpper.push(rowObject[index].__EMPTY_19)
                                        : console.log("assetno already exists");

                                    this.ownedrUpper.indexOf(rowObject[index].__EMPTY_20) === -1
                                        ? this.ownedrUpper.push(rowObject[index].__EMPTY_20)
                                        : console.log("ownedrUpper already exists");

                                    this.manfassUpper.indexOf(rowObject[index].__EMPTY_21) === -1
                                        ? this.manfassUpper.push(rowObject[index].__EMPTY_21)
                                        : console.log("asset manf already exists");

                                    this.manfUpper.indexOf(rowObject[index].__EMPTY_22) === -1
                                        ? this.manfUpper.push(rowObject[index].__EMPTY_22)
                                        : console.log("manf sr no already exists");

                                    this.indicatorUpper.indexOf(rowObject[index].__EMPTY_23) === -1
                                        ? this.indicatorUpper.push(rowObject[index].__EMPTY_23)
                                        : console.log("indicator upper already exists")

                                    this.coriginUpper.indexOf(rowObject[index].__EMPTY_24) === -1
                                        ? this.coriginUpper.push(rowObject[index].__EMPTY_24)
                                        : console.log("country of origin upper already exists");

                                    this.wdetailsUpper.indexOf(rowObject[index].__EMPTY_25) === -1
                                        ? this.wdetailsUpper.push(rowObject[index].__EMPTY_25)
                                        : console.log("warranty details upper already exists");

                                    this.ponoUpper.indexOf(rowObject[index].__EMPTY_26) === -1
                                        ? this.ponoUpper.push(rowObject[index].__EMPTY_26)
                                        : console.log("purchased asset order already exists");

                                    this.locationUpper.indexOf(rowObject[index].__EMPTY_27) === -1
                                        ? this.locationUpper.push(rowObject[index].__EMPTY_27)
                                        : console.log("local upper asset order already exists");

                                    this.custodianUpper.indexOf(rowObject[index].__EMPTY_28) === -1
                                        ? this.custodianUpper.push(rowObject[index].__EMPTY_28)
                                        : console.log("custodian asset order already exists");

                                    this.approvedbudgetUpper.indexOf(rowObject[index].__EMPTY_29) === -1
                                        ? this.approvedbudgetUpper.push(rowObject[index].__EMPTY_29)
                                        : console.log("approved budget order already exists");

                                    this.coriginUpper.indexOf(rowObject[index].__EMPTY_30) === -1
                                        ? this.coriginUpper.push(rowObject[index].__EMPTY_30)
                                        : console.log("cost orignal already exists");

                                    this.currentcostUpper.indexOf(rowObject[index].__EMPTY_31) === -1
                                        ? this.currentcostUpper.push(rowObject[index].__EMPTY_31)
                                        : console.log("current cost already exists");

                                    this.scrapvalueUpper.indexOf(rowObject[index].__EMPTY_32) === -1
                                        ? this.scrapvalueUpper.push(rowObject[index].__EMPTY_32)
                                        : console.log("scrap value already exists");

                                    let date3=moment.utc(rowObject[index].__EMPTY_33).local().format('YYYY-MM-DD HH:MM:SS');
                                    date3 = new Date(date3);
                                    date3=date3.setDate(date3.getDate() + 1);
                                    date3=moment.utc(date3).local().format('YYYY-MM-DD');
                                    this.captdateUpper.indexOf(date3) === -1
                                        ? this.captdateUpper.push(date3)
                                        : console.log("date 3 already exists");

                                    let date4=moment.utc(rowObject[index].__EMPTY_34).local().format('YYYY-MM-DD HH:MM:SS');
                                    date4 = new Date(date4);
                                    date4=date4.setDate(date4.getDate() + 1);
                                    date4=moment.utc(date4).local().format('YYYY-MM-DD');

                                    this.captdateUpper.indexOf(date4) === -1
                                        ? this.captdateUpper.push(date4)
                                        : console.log("date 4 already exists");

                                    this.usefullifeUpper.indexOf(rowObject[index].__EMPTY_35) === -1
                                        ? this.usefullifeUpper.push(rowObject[index].__EMPTY_35)
                                        : console.log("useful already exists");

                                    this.remaininglifeUpper.indexOf(rowObject[index].__EMPTY_36) === -1
                                        ? this.remaininglifeUpper.push(rowObject[index].__EMPTY_36)
                                        : console.log("remaining life already exists");

                                    this.depmethodUpper.indexOf(rowObject[index].__EMPTY_37) === -1
                                        ? this.depmethodUpper.push(rowObject[index].__EMPTY_37)
                                        : console.log("dep method already exists");

                                    this.deprateUpper.indexOf(rowObject[index].__EMPTY_38) === -1
                                        ? this.deprateUpper.push(rowObject[index].__EMPTY_38)
                                        : console.log("dep rate already exists");

                                    this.depreciationUpper.indexOf(rowObject[index].__EMPTY_39) === -1
                                        ? this.depreciationUpper.push(rowObject[index].__EMPTY_39)
                                        : console.log("depreciation already exists");

                                    this.accumdepUpper.indexOf(rowObject[index].__EMPTY_40) === -1
                                        ? this.accumdepUpper.push(rowObject[index].__EMPTY_40)
                                        : console.log("accum dep already exists");

                                    this.impchargesUpper.indexOf(rowObject[index].__EMPTY_41) === -1
                                        ? this.impchargesUpper.push(rowObject[index].__EMPTY_41)
                                        : console.log("imp charges already exists");

                                    this.accumimplossesUpper.indexOf(rowObject[index].__EMPTY_42) === -1
                                        ? this.accumimplossesUpper.push(rowObject[index].__EMPTY_42)
                                        : console.log("accum imp already exists");

                                    this.bookvalueUpper.indexOf(rowObject[index].__EMPTY_43) === -1
                                        ? this.bookvalueUpper.push(rowObject[index].__EMPTY_43)
                                        : console.log("book value already exists");

                                    this.depchargeaccUpper.indexOf(rowObject[index].__EMPTY_44) === -1
                                        ? this.depchargeaccUpper.push(rowObject[index].__EMPTY_44)
                                        : console.log("dep charge already exists");

                                    this.costcenterUpper.indexOf(rowObject[index].__EMPTY_45) === -1
                                        ? this.costcenterUpper.push(rowObject[index].__EMPTY_45)
                                        : console.log("charge acc already exists");

                                    let date5=moment.utc(rowObject[index].__EMPTY_46).local().format('YYYY-MM-DD HH:MM:SS');
                                    date5 = new Date(date5);
                                    date5=date5.setDate(date5.getDate() + 1);
                                    date5=moment.utc(date5).local().format('YYYY-MM-DD');

                                    this.revdateUpper.indexOf(date5) === -1
                                        ? this.revdateUpper.push(date5)
                                        : console.log("date5 already exists");

                                    this.revamountUpper.indexOf(rowObject[index].__EMPTY_47) === -1
                                        ? this.revamountUpper.push(rowObject[index].__EMPTY_47)
                                        : console.log("revamountUpper already exists");

                                    this.deprevamountUpper.indexOf(rowObject[index].__EMPTY_48) === -1
                                        ? this.deprevamountUpper.push(rowObject[index].__EMPTY_48)
                                        : console.log("deprevamountUpper already exists");

                                    this.accumdepUpper.indexOf(rowObject[index].__EMPTY_49) === -1
                                        ? this.accumdepUpper.push(rowObject[index].__EMPTY_49)
                                        : console.log("accumdepUpper already exists");

                                    let date6=moment.utc(rowObject[index].__EMPTY_50).local().format('YYYY-MM-DD HH:MM:SS');
                                    date6 = new Date(date6);
                                    date6=date6.setDate(date6.getDate() + 1);
                                    date6=moment.utc(date6).local().format('YYYY-MM-DD');

                                    this.planretirdateUpper.indexOf(date6) === -1
                                        ? this.planretirdateUpper.push(date6)
                                        : console.log("retirenment date already exists");

                                    this.lcompanyUpper.indexOf(rowObject[index].__EMPTY_51) === -1
                                        ? this.lcompanyUpper.push(rowObject[index].__EMPTY_51)
                                        : console.log("lease company already exists");

                                    this.lagreementnoUpper.indexOf(rowObject[index].__EMPTY_52) === -1
                                        ? this.lagreementnoUpper.push(rowObject[index].__EMPTY_52)
                                        : console.log("lease company already exists");

                                    this.lagreementdateUpper.indexOf(rowObject[index].__EMPTY_53) === -1
                                        ? this.lagreementdateUpper.push(rowObject[index].__EMPTY_53)
                                        : console.log("lease agreement date already exists");

                                    this.lstartdateUpper.indexOf(rowObject[index].__EMPTY_54) === -1
                                        ? this.lstartdateUpper.push(rowObject[index].__EMPTY_54)
                                        : console.log("lease len date already exists");

                                    this.leaselenUpper.indexOf(rowObject[index].__EMPTY_55) === -1
                                        ? this.leaselenUpper.push(rowObject[index].__EMPTY_55)
                                        : console.log("lease len date already exists");

                                }
                            }

                            //   console.log(this.nameUpper);

                            // this.form.assetno=rowObject[this.specific_row].__EMPTY_3;
                            // this.form.lassetno=rowObject[this.specific_row].__EMPTY_4;
                            // this.form.tangorintang=rowObject[this.specific_row].__EMPTY_5.toLowerCase();
                            // this.form.companycode=rowObject[this.specific_row].__EMPTY_6;
                            // this.form.assettype=rowObject[this.specific_row].__EMPTY_7;
                            // this.form.classification=rowObject[this.specific_row].__EMPTY_8.toLowerCase();
                            // this.form.category=rowObject[this.specific_row].__EMPTY_8.toLowerCase();
                            // this.form.units=rowObject[this.specific_row].__EMPTY_9;
                            // this.form.inuse=rowObject[this.specific_row].__EMPTY_10.toLowerCase();
                            // this.form.inphyicalinv=rowObject[this.specific_row].__EMPTY_11.toLowerCase();
                            // this.form.detaildesc=rowObject[this.specific_row].__EMPTY_12;
                            // this.form.assettagno=rowObject[this.specific_row].__EMPTY_13;
                            // this.form.ownedorleased=rowObject[this.specific_row].__EMPTY_14;
                            // this.form.manufacturer=rowObject[this.specific_row].__EMPTY_15;
                            // this.form.assetsno=rowObject[this.specific_row].__EMPTY_16;
                            // this.form.indicator=rowObject[this.specific_row].__EMPTY_17;
                            // this.form.countryoforigin=rowObject[this.specific_row].__EMPTY_18;
                            // this.form.warrentydetails=rowObject[this.specific_row].__EMPTY_19;
                            // this.form.pono=rowObject[this.specific_row].__EMPTY_20;
                            // this.form.location=rowObject[this.specific_row].__EMPTY_21;
                            // this.form.custodian=rowObject[this.specific_row].__EMPTY_22;
                            // this.form.approvedbudget=rowObject[this.specific_row].__EMPTY_23;
                            // this.form.assetcost=rowObject[this.specific_row].__EMPTY_24;
                            // this.form.currentcost=rowObject[this.specific_row].__EMPTY_25;
                            // this.form.scrapvalue=rowObject[this.specific_row].__EMPTY_26;
                            // this.form.captdate=rowObject[this.specific_row].__EMPTY_27;
                            // this.form.acqdate=rowObject[this.specific_row].__EMPTY_28;
                            // this.form.usefullife=rowObject[this.specific_row].__EMPTY_29;
                            // this.form.remaininglife=rowObject[this.specific_row].__EMPTY_30;
                            // this.form.depmethod=rowObject[this.specific_row].__EMPTY_31;
                            // this.form.deprate=rowObject[this.specific_row].__EMPTY_32;
                            // this.form.depreciation=rowObject[this.specific_row].__EMPTY_33;
                            // this.form.accumdep=rowObject[this.specific_row].__EMPTY_34;
                            // this.form.impcharges=rowObject[this.specific_row].__EMPTY_35;
                            // this.form.accumimplosses=rowObject[this.specific_row].__EMPTY_36;
                            // this.form.depchargeacc=rowObject[this.specific_row].__EMPTY_37;
                            // this.form.costcenter=rowObject[this.specific_row].__EMPTY_38;
                            // this.form.revdate=rowObject[this.specific_row].__EMPTY_39;
                            // this.form.revamount=rowObject[this.specific_row].__EMPTY_40;
                            // this.form.deprevamount=rowObject[this.specific_row].__EMPTY_41;
                            // this.form.accdeprevamount=rowObject[this.specific_row].__EMPTY_42;
                            // this.form.planretirdate=rowObject[this.specific_row].__EMPTY_43;
                            // this.form.lcompany=rowObject[this.specific_row].__EMPTY_44;
                            // this.form.lagreementno=rowObject[this.specific_row].__EMPTY_45;
                            // this.form.lagreementdate=rowObject[this.specific_row].__EMPTY_46;
                            // this.form.lstartdate=rowObject[this.specific_row].__EMPTY_47;
                            // this.form.leaselen=rowObject[this.specific_row].__EMPTY_48;
                        });
                    };
                }
            } else alert("selected file is not of valid extension..");
        }
    }
};
</script>

<style scoped>
.top-margin {
    margin-top: -1.3%;
}
</style>
