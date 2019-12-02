<template>
    <div class="container">
        <br />
        <h2>Dashboard</h2>

        <div class="row mb-5">
            <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        Total Students
                    </div>
                    <div class="card-body">
                        <h2> {{ totalStudents }} </h2>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6 col-md-6 col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        Total Male Students
                    </div>
                    <div class="card-body">
                        <h2> {{ totalMaleStudents }} </h2>
                    </div>
                </div>
            </div>

             <div class="col-sm-6 col-md-6 col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        Total Female Students
                    </div>
                    <div class="card-body">
                        <h2> {{ totalFemaleStudents }} </h2>
                    </div>
                </div>
            </div>

             <div class="col-sm-3 col-md-3 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        1st Year Students
                    </div>
                    <div class="card-body">
                        <h2> {{ totalFirstYearStudents }} </h2>
                    </div>
                </div>
            </div>

             <div class="col-sm-3 col-md-3 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        2nd Year Students
                    </div>
                    <div class="card-body">
                        <h2> {{ totalSecondYearStudents }} </h2>
                    </div>
                </div>
            </div>

             <div class="col-sm-3 col-md-3 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        3rd Year Students
                    </div>
                    <div class="card-body">
                        <h2> {{ totalThirdYearStudents }} </h2>
                    </div>
                </div>
            </div>
      
            <div class="col-sm-3 col-md-3 col-lg-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        4th Year Students
                    </div>
                    <div class="card-body">
                        <h2> {{ totalFourthYearStudents }} </h2>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6">
                <graph-bar
                    :width="500"
                    :height="500"
                    :axis-min="0"
                    :axis-max="500"
                    :labels="[ '1st', '2nd', '3rd', '4th' ]"
                    :values="[this.totalFirstYearStudents, this.totalSecondYearStudents, this.totalThirdYearStudents, this.totalFourthYearStudents]">
                    <note :text="'Student Counts in Every Year Level'"></note>
            
                </graph-bar>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6">
                <graph-pie
                    :width="500"
                    :height="500"
                    :padding-top="100"
                    :padding-bottom="100"
                    :padding-left="100"
                    :padding-right="100"
                    :active-index="[ 0, 1 ]"
                    :names="['Male Students', 'Female Students']"
                    :active-event="'click'"
                    :show-text-type="'outside'"
                    :data-format="dataFormat"
                    :values="[this.totalMaleStudents, this.totalFemaleStudents]">
                    <note :text="'Student Counts in Every Gender'"></note>
                    <legends :names="['Male Students', 'Female Students']"></legends>
                </graph-pie>
            </div>
        

           
      </div>
    </div>
</template>

<script>
export default {

    data() {
        
        return {
          
            totalStudents: '',
            totalMaleStudents: '',
            totalFemaleStudents: '',
            totalFirstYearStudents: '',
            totalSecondYearStudents: '',
            totalThirdYearStudents: '',
            totalFourthYearStudents: '',
           
        }
    },
    created() {
        
         axios.get('http://localhost:8000/api/summaryofstudents')
             .then(response => {
               this.totalStudents = response.data.count.students.totalStudents;
               this.totalMaleStudents = response.data.count.maleStudents.totalMaleStudents;
               this.totalFemaleStudents = response.data.count.femaleStudents.totalFemaleStudents;
               this.totalFirstYearStudents = response.data.count.firstYearStudents.totalFirstYearStudents;
               this.totalSecondYearStudents = response.data.count.secondYearStudents.totalSecondYearStudents;
               this.totalThirdYearStudents = response.data.count.thirdYearStudents.totalThirdYearStudents;
               this.totalFourthYearStudents = response.data.count.fourthYearStudents.totalFourthYearStudents;
               console.log(response)
             
            }
        );

    },
    methods: {
        dataFormat: function (x, y) {
            if(y) {
                return y;
                return x;
            }
        }
    }
    
}
</script>

<style scoped>

</style>