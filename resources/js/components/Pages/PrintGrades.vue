<template>
    <div class="container">
        <br />
        <h3>Print Grades</h3>
        <br />

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">

                <h5> Print By Year And Section </h5> 
       
                <table>
                    <tr>
                        <td>
                            <select v-model="sltLrnYear" class="form-control" @change="showSubjectInSpecificYear()">
                                <option value="" disabled selected>Select Year</option>
                                <option v-for="fetchYear in studentYear" :key="fetchYear.Year"> {{ fetchYear.Year }}</option>
                            </select>
                        </td>
                        <td>
                            <select v-model="sltLrnSection" class="form-control">
                                <option value="" disabled selected>Select Section</option>
                                <option v-for="fetchSection in studentSection" :key="fetchSection.section"> {{ fetchSection.section }}</option>
                            </select>
                        </td>
                        <td>
                            <select v-model="sltSubject" class="form-control">
                                <option value="" disabled selected>Select Subject</option>
                                <option v-for="fetchSubject in fetchedSubjectInfo" :key="fetchSubject.subj_name"> {{ fetchSubject.subj_name }}</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-info" @click="printList">Get Student List</button>
                            <button class="btn btn-success" @click="print">Print</button>
                        </td>
                    </tr>
                </table>            

            </div>
        </div>

        <hr />
        <br />
        <div class="row" id="printRecord">
                <h3>Grading Sheet</h3>
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h4> Year {{ sltLrnYear }} / Section {{ sltLrnSection }}</h4>

                <table class="table table-hover">
                    <tr>
                        <th> Student Name </th>
                        <th> Grade </th>
                    </tr>
                
                    <tr v-for="getStudentInfo in arrayOfData" :key="getStudentInfo.fullName">
                        <td> {{ getStudentInfo.fullName }} </td>
                        <td> {{ getStudentInfo.finalAve }} </td>
                    </tr>
                </table>
                
            </div>
            
        </div>

     
              
    </div>
</template>

<script>
export default {
    data() {
        return {
            studentYear: [],
            studentSection: [],
            sltLrnYear: '',
            sltLrnSection: '',
            output: null,
            arrayOfData: [],
            sltSubject: '',
            fetchedSubjectInfo: []
        }
    },
    created() {
        axios.get('http://localhost:8000/api/fetchStudentYearInLRN')
             .then(response => {
                 console.log(response)
                 this.studentYear = response.data;
        });  
        axios.get('http://localhost:8000/api/fetchStudentSection')
             .then(response => {
                 console.log(response)
                 this.studentSection = response.data;
        }); 
    },
    methods: {
       printList() {
        axios.get(`http://127.0.0.1:8000/api/printGrades/${this.sltLrnYear}/${this.sltLrnSection}/${this.sltSubject}`)
            .then(response => {
            console.log(response.data)
            this.arrayOfData = [];
          
            for(let i = 0; i < response.data.length; i++) {
                
                let FullName = response.data[i].criteas.exam.studentFullName;
                let FinalAverage = parseInt(response.data[i].criteas.exam.equivalent) +
                                   parseInt(response.data[i].criteas.assignment.equivalent) + 
                                   parseInt(response.data[i].criteas.project.equivalent) + 
                                   parseInt(response.data[i].criteas.quiz.equivalent) + 
                                   parseInt(response.data[i].criteas.recitation.equivalent);
                
                let finalOutput = {
                    'fullName': FullName,
                    'finalAve': FinalAverage
                }

                this.arrayOfData.push(finalOutput);
            }
            console.log(this.arrayOfData)
            
        });
          
       },
       showSubjectInSpecificYear() {
            axios.get('http://localhost:8000/api/showSubjectInYear/'+this.yearFilter(this.sltLrnYear)).then(
                response => {
                    this.fetchedSubjectInfo = response.data;      
            });
       },
       print() {
           this.$htmlToPaper('printRecord', () => {
               console.log('Print Na');
           });
       },
        yearFilter(studentYear) {
            if (studentYear == 1) {
                return '1st'
            } else if(studentYear == 2) {
                return '2nd'
            } else if(studentYear == 3) {
                return '3rd'
            } else if(studentYear == 4) {
                return '4th'
            }
        },   
    },
    
    
}
</script>

<style scoped>

</style>