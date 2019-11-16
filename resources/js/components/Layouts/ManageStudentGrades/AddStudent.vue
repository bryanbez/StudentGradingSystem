<template>
    <div class="container">
        <h3>Add Student</h3>
            <br />
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
</template>

<script>
export default {
    data: function() {
        return {
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
            }
        }
    },
    methods: {
        passAllInputs() {
            axios.post('http://localhost:8000/api/students', this.studentInfo).then(
                response => console.log(response)
            );
        }
    }
}
</script>

<style scoped>
input {
    width: 100%;
}
</style>