<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <br />
                    <div class="alert alert-info" v-if="message != ''">
                        <p> {{ message }}  <a style="float: right; cursor: pointer" @click="dismissMessage()">X</a></p>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                    </div>           
               <br />
                <h3>Exams of {{ studentFullName }}</h3>
                 <hr />
                   <h5> Total Exams: {{ overAllExamResult.exam_count }} </h5>
                  <hr />
                <h4>Add/ Update Exam Records</h4>
                  
                  <form @submit.prevent="saveOrUpdateExamRecord">
                    <table class="table table-bordered">
                        <tr>
                            <th> Date Given</th>
                            <th> No. of Items </th>
                            <th> Score </th>
                            <th colspan="2"> Options</th>
                        </tr>
                        <tr >
                            <td> <input type="date" class="form-control" v-model="input.dateOfExam"> </td>
                            <td> <input type="text" class="form-control" v-model="input.noOfItems"> </td>
                            <td> <input type="text" class="form-control" v-model="input.score"> </td>
                            <td> <button class="btn btn-primary" type="submit">Save</button> </td>
                           
                        </tr>
                    </table>
                    </form>
                     <td> <button class="btn btn-primary" @click="clearInputs()">Clear</button> </td>
                    <br />

              
                    <br />

                       <table class="table table-bordered" v-if="overAllExamResult.exam_count != 0">
                        <tr>
                            <th> Date Given</th>
                            <th> No. of Items </th>
                            <th> Score </th>
                            <th colspan="2"> Options</th>
                        </tr>
                        <tr v-for="singleExamInfo in allExamRecords" :key="singleExamInfo.exam_id">
                            <td> {{ singleExamInfo.date_of_exam }} </td>
                            <td> {{ singleExamInfo.no_of_items }} </td>
                            <td> {{ singleExamInfo.score }} </td>
                            <td> <button class="btn btn-primary" @click="editExamRecord(singleExamInfo.exam_id)">Edit</button> </td>
                            <td> <button class="btn btn-danger" @click="removeExamRecord(singleExamInfo.exam_id)">Remove</button> </td>
                        </tr>
                        <tr>
                            <td> Exam Final Average: </td>
                            <td colspan="3"> {{ overAllExamResult.equivalent }}  </td>
                      
                        </tr>
                    </table>

                    <p id="noResult" v-else> No Exam Records </p>

                    <br />

                    <router-link v-bind:to="{name: 'viewgrades', params:{student_lrn: this.input.student_lrn}}" class="btn btn-danger">Back</router-link>
                  
            </div>
        </div>
    </div>
</template>

<script>


export default {
    data() {
        return {
            examIdToUpdate: '',
            input: {
                student_lrn: '',
                dateOfExam: '',
                noOfItems: '',
                score: '',
            },
            allExamRecords: [],
            overAllExamResult: [],
            studentFullName: '',
            message: ''
         
        }
    },
    created() {
            this.input.student_lrn = this.$route.params.student_lrn;
            axios.get(`http://localhost:8000/api/fetchexams/${this.input.student_lrn}`).then(
                response =>  {
                    this.allExamRecords = response.data.exams;
                    this.overAllExamResult = response.data.overallExamData[0];
                    console.log(this.allExamRecords)
                });
            axios.get('http://localhost:8000/api/student/'+this.input.student_lrn)
                .then(response => {
                this.studentFullName = response.data[0].FullName;
            });
    },
    methods: {
        dismissMessage() {
           this.message = '';
        },
        saveOrUpdateExamRecord() {
            if(this.examIdToUpdate != '') {
                axios.put(`http://localhost:8000/api/exams/${this.examIdToUpdate}`, this.input).then(
                    response => {
                    console.log(response)
                    this.message = response.data;
                    this.refreshList()
                    this.clearInputs()
                    this.examIdToUpdate = ''
                });
            }
            else {
                axios.post('http://localhost:8000/api/exams', this.input).then(
                    response => {
                    console.log(response)
                    this.message = response.data;
                    this.refreshList()
                    this.clearInputs()      
                });
            }
        
        },
        clearInputs(){
            this.input.dateOfExam = '';
            this.input.noOfItems = '';
            this.input.score = '';
            this.examIdToUpdate = '';
        },
        editExamRecord(examID){
            axios.get(`http://localhost:8000/api/exams/${examID}/edit`).then(
                response => {
                    this.examIdToUpdate = response.data[0].exam_id;
                    this.input.dateOfExam = response.data[0].date_of_exam;
                    this.input.score = response.data[0].score;
                    this.input.noOfItems = response.data[0].no_of_items;
                    console.log(this.examIdToUpdate);
                }
            );
        },
        removeExamRecord(examID) {
            if(confirm('Are you sure to delete this record? ')){
                 axios.delete(`http://localhost:8000/api/exams/${examID}`).then(
                    response => {
                    this.message = response.data;
                    this.refreshList()
                });
            }
             
        },
        refreshList() {
              axios.get(`http://localhost:8000/api/fetchexams/${this.input.student_lrn}`).then(
                response => {
                    this.allExamRecords = response.data.exams;
                    this.overAllExamResult = response.data.overallExamData[0];
                    console.log(this.overAllExamResult)
                }
            );
        }
    
    },
   
    filters: {
        roundOff(value) {
            return Math.round(value)
        }
    }

}
</script>

<style scoped>
#noResult {
    font-weight: bold;
    font-size: 14px;
}
</style>