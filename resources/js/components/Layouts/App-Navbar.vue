<template>
    <div>
       <nav class="navbar navbar-expand-lg bg-secondary navbar-inverse">
         <div class="container">
            <div class="navbar-brand">
                <a> Student Grading System </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav">
              <span class="navbar-toggler-icon">

              </span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <router-link to="/" class="nav-link">Home</router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/managegrades" class="nav-link">Manage Student Grades</router-link>
                </li>
                 <li class="nav-item">
                  <router-link to="/printgrades" class="nav-link">Print Grades</router-link>
                </li>
              </ul>
            </div>
            
         </div>
       </nav>  
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.nav-link {
  color: white;
}
.navbar-brand a {
  color: white;
  font-weight: bold;
}
</style>
