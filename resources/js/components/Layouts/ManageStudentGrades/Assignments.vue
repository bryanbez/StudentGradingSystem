<template>
    <div>

        <div class="container">
            <div class="col-md-12 col-lg-12">
                <br />
                <div class="alert alert-info" v-if="message != ''">
                    <p> {{ message }}  <a style="float: right; cursor: pointer" @click="dismissMessage()">X</a></p>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                </div>
               <br />
                <h3>Assignments of {{ studentFullName }}</h3>
                 <hr />
                   <h5> Total Assignments: {{ assignmentResult.assignment_count }} </h5>
                  <hr />
                  <h5> Add/ Update Assignment Records</h5>
                  <form @submit.prevent="saveOrUpdateAssignmentRecord">
                    <table class="table table-bordered">
                        <tr>
                            <th> Date Given</th>
                            <th> Grade </th>
                            <th colspan="2"> Options</th>
                        </tr>
                        <tr >
                            <td> <input type="date" class="form-control" v-model="input.dateOfAssignment"> </td>
                            <td> <input type="text" class="form-control" v-model="input.grade"> </td>
                            <td> <button class="btn btn-primary" type="submit">Save</button> </td>  
                        </tr>
                    </table>
                    </form>
                     <td> <button class="btn btn-primary" @click="clearInputs()">Clear</button> </td>
                    <br />
                    <hr />
                    <h5> Assignment Records</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th> Date Given</th>
                            <th> Grade </th>
                            <th colspan="2"> Options </th>
                        </tr>
                        <tr v-for="singleAssignmentRecord in allAssignmentRecords" :key="singleAssignmentRecord.assignment_id">
                            <td> {{ singleAssignmentRecord.date_of_assignment }} </td>
                            <td> {{ singleAssignmentRecord.grade }} </td>
                           <td> <button class="btn btn-primary" @click="editAssignmentRecord(singleAssignmentRecord.assignment_id)">Edit</button> </td>
                            <td> <button class="btn btn-danger" @click="removeAssignmentRecord(singleAssignmentRecord.assignment_id)">Remove</button> </td>
                        </tr>
                        <tr>
                            <td>Final Grade in Assignment</td>
                            <td> {{ assignmentResult.equivalent }} ({{ assignmentResult.assignment_count }} of {{ assignmentResult.max_assignment_number}} assignment passed) </td>
                        </tr>
                    </table>
                    <br />
                    <hr />

                    <router-link v-bind:to="{name: 'viewgrades', params:{student_lrn: this.input.student_lrn}}" class="btn btn-danger">Back</router-link>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            assignmentIdToUpdate: '',
            input: {
                student_lrn: '',
                dateOfAssignment: '',
                grade: '',
            },
            allAssignmentRecords: [],
            studentFullName: '',
            assignmentResult: [],
            message: ''
         
        }
    },
    created() {
         this.input.student_lrn = this.$route.params.student_lrn;
          axios.get(`http://localhost:8000/api/fetchassignments/${this.input.student_lrn}`, ).then(
                response =>  {
                     this.allAssignmentRecords = response.data.assignments;
                     this.assignmentResult = response.data.overallData[0];  
                }
          );
          axios.get('http://localhost:8000/api/student/'+this.input.student_lrn)
             .then(response => {
                this.studentFullName = response.data[0].FullName;
          });
    },
    methods: {
       dismissMessage() {
           this.message = '';
       },
       saveOrUpdateAssignmentRecord() {
             if(this.assignmentIdToUpdate != '') {
                axios.put(`http://localhost:8000/api/assignments/${this.assignmentIdToUpdate}`, this.input).then(
                    response => {
                    console.log(response)
                    this.message = response.data;
                    this.refreshList()
                    this.clearInputs()
                });
            }
            else {
                axios.post('http://localhost:8000/api/assignments', this.input).then(
                    response => {
                    console.log(response)
                    this.message = response.data;
                    this.refreshList()
                    this.clearInputs()      
                });
            }
       },
       editAssignmentRecord(assignmentID) {
            axios.get(`http://localhost:8000/api/assignments/${assignmentID}/edit`).then(
                response => {
                    console.log(response)
                    this.assignmentIdToUpdate = response.data[0].assignment_id;
                    this.input.dateOfAssignment = response.data[0].date_of_assignment;
                    this.input.grade = response.data[0].grade;
                  
                }
            );

       },
       removeAssignmentRecord(assignmentID) {
            if(confirm('Are you sure to delete this record? ')){
                 axios.delete(`http://localhost:8000/api/assignments/${assignmentID}`).then(
                    response => {
                    this.message = response.data;
                    this.refreshList()
                    }
                );
            }
       },
       clearInputs() {
            this.assignmentIdToUpdate = '';
            this.input.dateOfAssignment = '';
            this.input.grade = '';
       },
       refreshList() {
            axios.get(`http://localhost:8000/api/fetchassignments/${this.input.student_lrn}`, ).then(
                response =>  {
                      this.allAssignmentRecords = response.data.assignments;
                      this.assignmentResult = response.data.overallData[0];     
                }
          );
          
       }
     
      
    }

}
</script>

<style scoped>

</style>