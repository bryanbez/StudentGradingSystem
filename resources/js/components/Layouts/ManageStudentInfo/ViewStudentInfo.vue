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
                    <p> Full Name: <b> {{ studentInfo.FullName }} </b> </p> 
                    <p> Age: <b>{{ studentInfo.studentAge }}</b> </p>
                    <p> Gender: <b>{{ studentInfo.studentGender | toUppercase }}</b> </p>
                    <p> Year: <b>{{ studentInfo.schoolYear }}</b> </p>
                    <p> Section: <b>{{ studentInfo.section }}</b> </p>
                    <p> Bldg/Rm No: <b>{{ studentInfo.bldg_rmNo }}</b> </p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary"> Modify Information</button>
                    <router-link to="/managegrades" class="btn btn-danger">Back</router-link>
                </div>

            </div>
            <br />

            <div id="modifyStudentInfo">
                <form action="" @submit.prevent="passAllInputs()">
                    <div class="col-md-12 col-lg-12 mb-2">
                        <label for="">Student LRN</label>
                        <input class="form-control" type="text" v-model="studentInfo.txtLRN" />   
                    </div>
                    <div class="col-md-12 col-lg-12 mb-2">
                        <label for=""> First Name</label>
                        <input class="form-control" type="text" v-model="studentInfo.txtFirstName"/>   
                    </div>
                    <div class="col-md-12 col-lg-12 mb-2">
                        <label for=""> Middle Name</label>
                        <input class="form-control" type="text" v-model="studentInfo.txtMiddleName" />   
                    </div>
                    <div class="col-md-12 col-lg-12 mb-2">
                        <label for=""> Last Name</label>
                        <input class="form-control" type="text" v-model="studentInfo.txtLastName" />   
                    </div>
                    <div class="col-md-12 col-lg-12 mb-2">
                        <label for=""> Age </label>
                        <input class="form-control" type="text" v-model="studentInfo.txtAge" />   
                    </div>
                    <div class="col-md-12 col-lg-12 mb-2">
                        <label for=""> Gender </label>
                        <select class="form-control" name="" id="" v-model="studentInfo.sltGender">
                            <option value="" selected disabled>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
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
                    </div>
                    <div class="col-md-12 col-lg-12 mb-2">
                        <label for=""> Section </label>
                        <input class="form-control" type="text" v-model="studentInfo.txtSection"/>   
                    </div>
                    <div class="col-md-12 col-lg-12 mb-2">
                        <label for=""> Bldg / Rm No </label>
                        <input class="form-control" type="text" v-model="studentInfo.txtBldgRmNo"/>   
                    </div>

                    <div class="col-md-12 col-lg-12 mt-5">
                    <button type="submit" class="btn btn-primary">Add Student</button>
                    <button class="btn btn-danger">Back</button>
                    </div>
                </form>
            </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            student_lrn: '',
            studentInfo: [],
        }
    },
    created() {
        this.student_lrn = this.$route.params.student_lrn;
        axios.get('http://localhost:8000/api/student/'+this.student_lrn)
            .then(response => {
            this.studentInfo = response.data[0];
            console.log(this.studentInfo)
        });

    },
    methods: {

    },
    filters: {
        toUppercase: function(value) {
            return value.toUpperCase();
        }
    }
    
}
</script>

<style scoped>
.card {
    font-size: 15px;
}
</style>