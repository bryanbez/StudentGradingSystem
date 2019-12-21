<template>
    <div class="container">
        <br />

        <h3> Viewing Grades of {{ studentFullName }} in {{ subj_name }}  </h3> 
        <div class="row">

          <div class="card">
            <div class="card-header">
               {{ examRecords.critea_name }}
            </div>
            <div class="card-body">
                <p> Critea Percentage: {{examRecords.critea_percentage | addPercentageSymbol}} </p>
                <p> Exam Count: {{ examRecords.exam_count }}</p>
                <p>Final Grade: {{ examRecords.finalGrade | addPercentageSymbol}}</p>
                <p>Equivalent: {{ examRecords.equivalent | cutDecimals }}</p>
            </div>
            <div class="card-footer">
                 <router-link v-bind:to="{name: 'exam', params:{student_lrn: this.student_lrn, subject_code: subj_code}}" class="btn btn-primary">Add/ Update Exam Records</router-link>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
               {{ assignmentRecords.critea_name }}
            </div>
            <div class="card-body">
                <p> Critea Percentage: {{assignmentRecords.critea_percentage | addPercentageSymbol}} </p>
                 <p> Assignment Count: {{ assignmentRecords.assignment_count }}</p>
                <p>Final Grade: {{ assignmentRecords.finalGrade | addPercentageSymbol}}</p>
                <p>Equivalent: {{ assignmentRecords.equivalent | cutDecimals }}</p>
            </div>
            <div class="card-footer">
                  <router-link v-bind:to="{name: 'assignment', params:{student_lrn: this.student_lrn, subject_code: subj_code}}" class="btn btn-primary">Add/ Update Assignment Records</router-link>
            </div>
          </div>

           <div class="card">
            <div class="card-header">
               {{ projectRecords.critea_name }}
            </div>
            <div class="card-body">
                <p> Critea Percentage: {{projectRecords.critea_percentage | addPercentageSymbol}} </p>
                <p> Project Count: {{ projectRecords.project_count }}</p>
                <p>Final Grade: {{ projectRecords.finalGrade | addPercentageSymbol}}</p>
                <p>Equivalent: {{ projectRecords.equivalent | cutDecimals }}</p>
            </div>
            <div class="card-footer">
                   <router-link v-bind:to="{name: 'project', params:{student_lrn: this.student_lrn, subject_code: subj_code, student_year: school_yr}}" class="btn btn-primary">Add/ Update Project Records</router-link>
            </div>
          </div>

            <div class="card">
            <div class="card-header">
               {{ quizRecords.critea_name }}
            </div>
            <div class="card-body">
                <p> Critea Percentage: {{quizRecords.critea_percentage | addPercentageSymbol}} </p>
                 <p> Quiz Count: {{ quizRecords.quiz_count }}</p>
                <p>Final Grade: {{ quizRecords.finalGrade | addPercentageSymbol}}</p>
                <p>Equivalent: {{ quizRecords.equivalent | cutDecimals }}</p>
            </div>
            <div class="card-footer">
                  <router-link v-bind:to="{name: 'quiz', params:{student_lrn: this.student_lrn, subject_code: subj_code}}" class="btn btn-primary">Add/ Update Quiz Records</router-link>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
               {{ recitationRecords.critea_name }}
            </div>
            <div class="card-body">
                <p> Critea Percentage: {{recitationRecords.critea_percentage | addPercentageSymbol}} </p>
                 <p> Recitation Count: {{ recitationRecords.recitation_count }}</p>
                <p>Final Grade: {{ recitationRecords.finalGrade | addPercentageSymbol}}</p>
                <p>Equivalent: {{ recitationRecords.equivalent | cutDecimals }}</p>
            </div>
            <div class="card-footer">
                 <router-link v-bind:to="{name: 'recitation', params:{student_lrn: this.student_lrn, subject_code: subj_code}}" class="btn btn-primary">Add/ Update Recitation Records</router-link>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              Final Grade
            </div>
            <div class="card-body" id="finalGrade">
                {{ calculateFinalGrade }}
            </div>
            <div class="card-footer">
              
            </div>
          
          </div>
             
        </div>

            <router-link v-bind:to="{name: 'managestudentsubjectgrades', params:{student_lrn: student_lrn, student_year: school_yr}}" class="btn btn-danger"> Back </router-link>
      
    </div>
</template>

<script>

export default {
    components: {
     
        
    },
    data: function() {
        return {
            studentFullName: '',
            student_lrn: '',
            criteas: [],
            examRecords: [],
            assignmentRecords: [],
            projectRecords: [],
            quizRecords: [],
            recitationRecords: [],
            subj_code: '',
            subj_name: '',
            school_yr: ''

        }
    },
    created() {
        this.student_lrn = this.$route.params.student_lrn;
        this.subj_code = this.$route.params.subject_code;
        this.school_yr = this.$route.params.student_year;
        console.log(this.subj_code)

        axios.get('http://localhost:8000/api/student/'+this.student_lrn)
             .then(response => {
                this.studentFullName = response.data[0].studentLastName + ', ' + response.data[0].studentFirstName + ' ' + response.data[0].studentMiddleName; 
            }
        );

        axios.get(`http://localhost:8000/api/subject/${this.subj_code}`).then(
            response => {
               this.subj_name = response.data[0].subj_name;
        });

        axios.get(`http://127.0.0.1:8000/api/fetchStudentRecords/${this.student_lrn}/${this.subj_code}`)
             .then(response => {
                this.criteas = response.data;
                this.examRecords = response.data.examRecords[0];
                this.assignmentRecords = response.data.assignmentRecords[0];
                this.projectRecords = response.data.projectRecords[0];
                this.quizRecords = response.data.quizRecords[0];
                this.recitationRecords = response.data.recitationRecords[0];

            }
        );

    },
    computed: {
      calculateFinalGrade: function() {
         let finalGrade = parseInt(this.examRecords.equivalent) + parseInt(this.assignmentRecords.equivalent) +
                parseInt(this.projectRecords.equivalent) + parseInt(this.quizRecords.equivalent) +
                parseInt(this.recitationRecords.equivalent);
          return finalGrade;
      },

  
    },
    filters: {
        addPercentageSymbol(value) {
            return Math.round(value).toFixed(2)+ '%';
        },
        cutDecimals(value) {
          return Math.round(value).toFixed(2);
        }
    
    
    }
}
</script>

<style scoped>
.card {
  margin: 2em;
}
.card-header {
  font-weight: bold;
  font-size: 20px;
}
#finalGrade {
  font-weight: bold;
  font-size: 24px;
}
</style>