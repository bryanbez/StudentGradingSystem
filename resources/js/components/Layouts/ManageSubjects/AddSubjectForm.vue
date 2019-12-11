<template>
    <div class="container">
        <form @submit.prevent="addSubject">
            <div class="alert alert-info" v-if="statusOfUpdate === 200">
                    {{ insertMsg }}
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                <label for="">Subject Code</label>
                <input class="form-control" type="text" v-model="subjectInfo.txtSubjCode" />  
                <span v-if="insertMsg.txtSubjCode" class="error"> {{ insertMsg.txtSubjCode | trimCharacters }}</span> 
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                 <label for="">Subject for Year</label>
                 <select v-model="subjectInfo.sltLrnYear" class="form-control">
                    <option value="" disabled selected>Select Year</option>
                    <option v-for="fetchYear in studentYear" :key="fetchYear.Year"> {{ fetchYear.Year | schoolYear }}</option>
                </select>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                <label for="">Subject Name</label>
                <input class="form-control" type="text" v-model="subjectInfo.txtSubjName" />
                <span v-if="insertMsg.txtSubjName" class="error"> {{ insertMsg.txtSubjName | trimCharacters }}</span>   
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                <label for="">Subject Description</label>
                <textarea class="form-control" type="text" v-model="subjectInfo.txtSubjDesc" rows="10">  </textarea>
                <span v-if="insertMsg.txtSubjDesc" class="error"> {{ insertMsg.txtSubjDesc | trimCharacters }}</span>
            </div>

              <div class="col-md-12 col-lg-12 mt-5">
                <button type="submit" class="btn btn-primary">Add Subject</button>
            </div>

        </form>

    </div>
</template>

<script>

export default {
    data() {
        return {
            subjectInfo: {
                txtSubjCode: '',
                sltLrnYear: '',
                txtSubjName: '',
                txtSubjDesc: ''
            },
           
            studentYear: [],
            statusOfUpdate: '',
            insertMsg: '',
        }
    },
    created() {
         axios.get('http://localhost:8000/api/fetchStudentYearInLRN')
             .then(response => {
                 console.log(response)
                 this.studentYear = response.data;
        });  
    },
    methods: {
        addSubject() {
            axios.post('http://localhost:8000/api/subject', this.subjectInfo)
                .then(response => {
                    console.log(response)
                    this.statusOfUpdate = response.status;
                    this.insertMsg = response.data.original;
                    this.refreshList(response.status)
                    this.clearTextbox()
            }).catch(error => {
                 this.statusOfUpdate = error.response.status;
                 this.insertMsg = error.response.data.errors;
            });  
        },
        clearTextbox() {
            this.subjectInfo.txtSubjCode = '';
            this.subjectInfo.txtSubjName = '';
            this.subjectInfo.txtSubjDesc = '';
        },
        refreshList(status) {
            this.$emit('refreshList', status);
        }
   
     
      

    },
    filters: {
        trimCharacters: function(value) {
            return value.toString();
        },
        schoolYear(value) {
            if (value == 1) {
                return '1st';
            }
            else if(value == 2) {
                return '2nd';
            }
            else if(value == 3) {
                return '3rd';
            }
            else if (value == 4) {
                return '4th';
            }
            else {
                // Null
            }
        }
    },
}
</script>

<style scoped>
.error {
    color: red;
}
</style>