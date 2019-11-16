<template>
    <div>

        <div class="container">
            <div class="col-md-12 col-lg-12">
                <br />
                <h3>Quizzes of {{ studentFullName }}</h3>
                 <hr />
                   <h4> Total Quizzes Take: {{ quizResults.quiz_count }} </h4>
                  <hr />
                  <h4> Add/ Update Quiz Records</h4>
                  <form @submit.prevent="saveOrUpdateQuizRecord">
                    <table class="table table-bordered">
                        <tr>
                            <th> Date Given</th>
                            <th> No. of Items </th>
                            <th> Score </th>
                            <th colspan="2"> Options</th>
                        </tr>
                        <tr >
                            <td> <input type="date" class="form-control" v-model="input.dateOfQuiz"> </td>
                            <td> <input type="text" class="form-control" v-model="input.noOfItems"> </td>
                            <td> <input type="text" class="form-control" v-model="input.score"> </td>
                            <td> <button class="btn btn-primary" type="submit">Save</button> </td>
                        </tr>
                    </table>
                    </form>
                     <td> <button class="btn btn-primary" @click="clearInputs()">Clear</button> </td>
                    <br />
                     <hr />

                    <h4> Quiz Records</h4>
                    <table class="table table-bordered">
                        <tr>
                            <th> Date Given</th>
                            <th> No. of Items </th>
                            <th> Score </th>
                            <th colspan="2"> Options</th>
                        </tr>
                        <tr v-for="singleQuizRecord in allQuizRecords" :key="singleQuizRecord.quiz_id">
                            <td> {{ singleQuizRecord.date_of_quiz }} </td>
                            <td> {{ singleQuizRecord.no_of_items }} </td>
                            <td> {{ singleQuizRecord.score }} </td>
                           <td> <button class="btn btn-primary" @click="editQuizRecord(singleQuizRecord.quiz_id)">Edit</button> </td>
                            <td> <button class="btn btn-danger" @click="removeQuizRecord(singleQuizRecord.quiz_id)">Remove</button> </td>
                        </tr>
                        <tr>
                            <td> Quiz Grade:  </td>
                            <td colspan="4"> {{ quizResults.equivalent }} ({{ quizResults.quiz_count }} of {{ quizResults.max_quiz_number}} quiz taken) </td>
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
            quizIdToUpdate: '',
            input: {
                student_lrn: '',
                dateOfQuiz: '',
                noOfItems: '',
                score: '',
            },
            allQuizRecords: [],
            
            studentFullName: '',
            quizResults: []
         
        }
    },
    created() {
         this.input.student_lrn = this.$route.params.student_lrn;
          axios.get(`http://localhost:8000/api/fetchquiz/${this.input.student_lrn}`).then(
                response =>  {
                     this.allQuizRecords = response.data.quizzez;
                     this.quizResults = response.data.overallData[0];
                     console.log(response.data)
                }
          );

            axios.get('http://localhost:8000/api/student/'+this.input.student_lrn)
             .then(response => {
                this.studentFullName = response.data[0].FullName;
            }
        );
    },
    methods: {
       saveOrUpdateQuizRecord() {
             if(this.quizIdToUpdate != '') {
                axios.put(`http://localhost:8000/api/quiz/${this.quizIdToUpdate}`, this.input).then(
                    response => {
                    console.log(response)
                    this.refreshList()
                    this.clearInputs()
                });
            }
            else {
                axios.post('http://localhost:8000/api/quiz', this.input).then(
                    response => {
                    console.log(response)
                    this.refreshList()
                    this.clearInputs()      
                });
            }
       },
       editQuizRecord(quizID) {
            axios.get(`http://localhost:8000/api/quiz/${quizID}/edit`).then(
                response => {
                    console.log(response)
                    this.quizIdToUpdate = response.data[0].quiz_id;
                    this.input.dateOfQuiz = response.data[0].date_of_quiz;
                    this.input.noOfItems = response.data[0].no_of_items;
                    this.input.score = response.data[0].score;
                  
                }
            );

       },
       removeQuizRecord(quizID) {
            if(confirm('Are you sure to delete this record? ')){
                 axios.delete(`http://localhost:8000/api/quiz/${quizID}`).then(
                    response => {
                    alert(response.data)
                    this.refreshList()
                    }
                );
            }
       },
       clearInputs() {
            this.quizIdToUpdate = '';
            this.input.dateOfQuiz = '';
            this.input.noOfItems = '';
            this.input.score = '';
       },
       refreshList() {
             axios.get(`http://localhost:8000/api/fetchquiz/${this.input.student_lrn}`).then(
                response =>  {
                    this.allQuizRecords = response.data.quizzez;
                   this.quizResults = response.data.overallData[0];
                    
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

</style>