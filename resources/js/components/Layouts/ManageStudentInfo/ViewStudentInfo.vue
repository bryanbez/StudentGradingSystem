<template>
    <div class="container">
         <br />
           
            <h3> View Student Info </h3>
            <br />

            <div class="card">
                <div class="card-header">
                    Student No: <b> {{ student_lrn }} </b>
                </div>
                <div class="card-body">
                    <p> Last Name: <b> {{ studentInfoToFetch.studentLastName }} </b> </p> 
                    <p> First Name: <b> {{ studentInfoToFetch.studentFirstName }} </b> </p> 
                    <p> Middle Name: <b> {{ studentInfoToFetch.studentMiddleName }} </b> </p> 
                    <p> Age: <b>{{ studentInfoToFetch.studentAge }}</b> </p>
                    <p> Gender: <b>{{ studentInfoToFetch.studentGender }}</b> </p>
                    <p> Year: <b>{{ studentInfoToFetch.schoolYear }}</b> </p>
                    <p> Section: <b>{{ studentInfoToFetch.section }}</b> </p>
                    <p> Bldg/Rm No: <b>{{ studentInfoToFetch.bldg_rmNo }}</b> </p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" data-toggle="modal" @click="putFetchedRecordInInputs()" data-target="#modifyStudentInfo"> Modify Information</button>
                    <router-link to="/managegrades" class="btn btn-danger">Back</router-link>
                </div>

            </div>
            <br />

            <div class="modal fade" id="modifyStudentInfo" tab-index="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Update Student Information </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="alert alert-success" v-if="statusOfUpdate == 200">
                                    {{ updateMsg }}
                                </div>
                                  <form action="">
                                    <div class="col-md-12 col-lg-12 mb-2">
                                        <label for="">Student LRN</label>
                                        <input class="form-control" type="text" disabled v-model="studentInfo.txtLRN" />   
                                    </div>
                                    <div class="col-md-12 col-lg-12 mb-2">
                                        <label for=""> First Name</label>
                                        <input class="form-control" type="text" v-model="studentInfo.txtFirstName"/> 
                                        <span v-if="updateMsg.txtFirstName" class="error"> {{ updateMsg.txtFirstName | trimCharacters }}</span>  
                                    </div>
                                    <div class="col-md-12 col-lg-12 mb-2">
                                        <label for=""> Middle Name</label>
                                        <input class="form-control" type="text" v-model="studentInfo.txtMiddleName" />
                                         <span v-if="updateMsg.txtMiddleName" class="error"> {{ updateMsg.txtMiddleName | trimCharacters }}</span>    
                                    </div>
                                    <div class="col-md-12 col-lg-12 mb-2">
                                        <label for=""> Last Name</label>
                                        <input class="form-control" type="text" v-model="studentInfo.txtLastName" />   
                                         <span v-if="updateMsg.txtLastName" class="error"> {{ updateMsg.txtLastName | trimCharacters }}</span> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 mb-2">
                                        <label for=""> Age </label>
                                        <input class="form-control" type="text" v-model="studentInfo.txtAge" />   
                                        <span v-if="updateMsg.txtAge" class="error"> {{ updateMsg.txtAge | trimCharacters }}</span> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 mb-2">
                                        <label for=""> Gender </label>
                                        <select class="form-control" name="" id="" v-model="studentInfo.sltGender">
                                            <option value="" selected disabled>Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <span v-if="updateMsg.sltGender" class="error"> {{ updateMsg.sltGender | trimCharacters }}</span> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 mb-2">
                                        <label for=""> Year </label>
                                        <select class="form-control" name="" id="" v-model="studentInfo.sltYear">
                                            <option value="" selected disabled>Select Year</option>
                                            <option value="1">1st Year</option>
                                            <option value="2">2nd Year</option>
                                            <option value="3">3rd Year</option>
                                            <option value="4">4th Year</option>
                                        </select>
                                        <span v-if="updateMsg.sltYear" class="error"> {{ updateMsg.sltYear | trimCharacters }}</span> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 mb-2">
                                        <label for=""> Section </label>
                                        <input class="form-control" type="text" v-model="studentInfo.txtSection"/>   
                                        <span v-if="updateMsg.txtSection" class="error"> {{ updateMsg.txtSection | trimCharacters }}</span> 
                                    </div>
                                    <div class="col-md-12 col-lg-12 mb-2">
                                        <label for=""> Bldg / Rm No </label>
                                        <input class="form-control" type="text" v-model="studentInfo.txtBldgRmNo"/>   
                                         <span v-if="updateMsg.txtBldgRmNo" class="error"> {{ updateMsg.txtBldgRmNo | trimCharacters }}</span> 
                                    </div>
                                </form>
                        </div>
                        <div class="modal-footer">
                            <button @click="updateStudentInformation()" class="btn btn-primary">Save Changes</button>
                            <button class="btn btn-danger" data-dismiss="modal">Back</button>
                        </div>  
                    </div>
                </div>
          
            </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            student_lrn: '',
            studentInfoToFetch: [],
            studentInfo: {
                txtLRN: '',
                txtFirstName: '',
                txtMiddleName: '',
                txtLastName: '',
                txtAge: '',
                sltGender: '',
                sltYear: '',
                txtSection: '',
                txtBldgRmNo: ''
            },
            updateMsg: '',
            statusOfUpdate: '',
        }
    },
    created() {
        this.student_lrn = this.$route.params.student_lrn;
        axios.get('http://localhost:8000/api/student/'+this.student_lrn)
            .then(response => {
            this.studentInfoToFetch = response.data[0];
            console.log(this.studentInfo)
        });

    },
    methods: {
        putFetchedRecordInInputs() {
            this.studentInfo.txtLRN = this.student_lrn;
            this.studentInfo.txtFirstName = this.studentInfoToFetch.studentFirstName;
            this.studentInfo.txtLastName = this.studentInfoToFetch.studentLastName;
            this.studentInfo.txtMiddleName = this.studentInfoToFetch.studentMiddleName
            this.studentInfo.txtAge = this.studentInfoToFetch.studentAge;
            this.studentInfo.sltGender = this.studentInfoToFetch.studentGender;
            this.studentInfo.sltYear = this.studentInfoToFetch.schoolYear;
            this.studentInfo.txtSection = this.studentInfoToFetch.section;
            this.studentInfo.txtBldgRmNo = this.studentInfoToFetch.bldg_rmNo;
        },
        updateStudentInformation() {
            axios.put(`http://localhost:8000/api/students/${this.student_lrn}`, this.studentInfo).then(
                response => {
                console.log(response)
                this.updateMsg = response.data;
                this.statusOfUpdate = response.status;
                this.refreshData();
            }).catch(error => {
                 this.statusOfUpdate = error.response.status;
                 this.updateMsg = error.response.data.errors;
            });
        },
        refreshData() {
             axios.get('http://localhost:8000/api/student/'+this.student_lrn)
                .then(response => {
                this.studentInfoToFetch = response.data[0];
                console.log(this.studentInfo)
            });
        }

    },
   
    filters: {
        trimCharacters: function(value) {
            return value.toString();
        }
    }
    
}
</script>

<style scoped>
.card {
    font-size: 15px;
}
.error {
    color: brown;
}
</style>