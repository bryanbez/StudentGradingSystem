<template>
    <div class="container">
           
            <form action="" @submit.prevent="passAllInputs()">
                <div class="alert alert-success" v-if="statusOfUpdate === 200">
                    {{ insertMsg }}
                </div>
                <div class="col-md-12 col-lg-12 mb-2">
                    <label for="">Student LRN</label>
                    <input class="form-control" type="text" v-model="studentInfo.txtLRN" />   
                    <span v-if="insertMsg.txtLRN" class="error"> {{ insertMsg.txtLRN | trimCharacters }} </span>   
                </div>
                <div class="col-md-12 col-lg-12 mb-2">
                    <label for=""> First Name</label>
                    <input class="form-control" type="text" v-model="studentInfo.txtFirstName"/> 
                    <span v-if="insertMsg.txtFirstName" class="error"> {{ insertMsg.txtFirstName | trimCharacters }}</span>    
                </div>
                 <div class="col-md-12 col-lg-12 mb-2">
                    <label for=""> Middle Name</label>
                    <input class="form-control" type="text" v-model="studentInfo.txtMiddleName" />
                    <span v-if="insertMsg.txtMiddleName" class="error"> {{ insertMsg.txtMiddleName | trimCharacters }}</span>   
                </div>
                 <div class="col-md-12 col-lg-12 mb-2">
                    <label for=""> Last Name</label>
                    <input class="form-control" type="text" v-model="studentInfo.txtLastName" />   
                    <span v-if="insertMsg.txtLastName" class="error"> {{ insertMsg.txtLastName | trimCharacters }}</span>  
                </div>
                <div class="col-md-12 col-lg-12 mb-2">
                    <label for=""> Age </label>
                    <input class="form-control" type="text" v-model="studentInfo.txtAge" />
                    <span v-if="insertMsg.txtAge" class="error"> {{ insertMsg.txtAge | trimCharacters }}</span>
                </div>
                 <div class="col-md-12 col-lg-12 mb-2">
                    <label for=""> Gender </label>
                    <select class="form-control" name="" id="" v-model="studentInfo.sltGender">
                        <option value="" selected disabled>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <span v-if="insertMsg.sltGender" class="error"> {{ insertMsg.sltGender | trimCharacters }}</span>
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
                    <span v-if="insertMsg.sltYear" class="error"> {{ insertMsg.sltYear | trimCharacters }}</span>
                </div>
                 <div class="col-md-12 col-lg-12 mb-2">
                    <label for=""> Section </label>
                    <input class="form-control" type="text" v-model="studentInfo.txtSection"/>   
                    <span v-if="insertMsg.txtSection" class="error"> {{ insertMsg.txtSection | trimCharacters }}</span>
                </div>
                 <div class="col-md-12 col-lg-12 mb-2">
                    <label for=""> Bldg / Rm No </label>
                    <input class="form-control" type="text" v-model="studentInfo.txtBldgRmNo"/>   
                    <span v-if="insertMsg.txtBldgRmNo" class="error"> {{ insertMsg.txtBldgRmNo | trimCharacters }}</span>
                </div>

                <div class="col-md-12 col-lg-12 mt-5">
                   <button type="submit" class="btn btn-primary">Add Student</button>
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
            },
            statusOfUpdate: '',
            insertMsg: '',
        }
    },
    methods: {
        passAllInputs() {
            axios.post('http://localhost:8000/api/students', this.studentInfo).then(
                response => {
                 console.log(response)
                  this.statusOfUpdate = response.status;
                  this.insertMsg = response.data;
            }).catch(error => {
                 this.statusOfUpdate = error.response.status;
                 this.insertMsg = error.response.data.errors;
              
            });
        },
      
    },
    filters: {
        trimCharacters: function(value) {
            return value.toString();
        }
    },

   
}
</script>

<style scoped>
input {
    width: 100%;
}
.error {
    color: brown;
}

</style>