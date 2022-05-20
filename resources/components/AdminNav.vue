<template>
 <header :class="{ 'is-transformed': !showNavbar }" class="navbar is-fixed-top is-transparent is-spaced" >
    <div class="container">
      <div class="navbar-brand is-family-secondary">
          <router-link :to="{name:'Home'}" class="navbar-item">
              <figure class="logo">
                <img src="/img/see_logo_10-apr-2022.png" alt="see southern dot com">
              </figure>
        </router-link>
        <a :aria-expanded="isActive" :class="{ 'is-active': isActive }" role="button" class="navbar-burger" aria-label="menu" data-target="collapse" @click="isActive = !isActive" >
          <span aria-hidden="true" />
          <span aria-hidden="true" />
          <span aria-hidden="true" />
        </a>
      </div>
      <div id="collapse" :class="{ 'is-active': isActive }" class="navbar-menu is-paddingless" >
        <nav class="navbar-end">
            <!--
          <router-link to="http://blp.proj" class="navbar-item">Home</router-link>
            -->


            <span>
                <router-link class="navbar-item is-uppercase has-text-weight-bold" 
                             :to="{name:'MemberDashboard'}">home</router-link>
            </span>
            <span>
                <router-link class="navbar-item is-uppercase  has-text-weight-bold" 
                             :to="{name:'About'}">about</router-link>
            </span>
            <span>
                <router-link class="navbar-item is-uppercase  has-text-weight-bold" 
                             :to="{name:'Blog'}">blog</router-link>
            </span>
            
            <button class="button is-info mr-2 is-outlined is-rounded">
                <font-awesome-icon 
                    icon="user"></font-awesome-icon>
            </button>

            <button class="button is-danger is-outlined is-rounded">
                <font-awesome-icon 
                    icon="right-from-bracket"></font-awesome-icon>
            </button>


        </nav>
      </div>
    </div>
  </header>
</template>

<script>
import throttle from 'lodash/throttle'

export default {
    name:'AdminNav',
  data() {
    return {
      isActive: false,
      showNavbar: true,
      lastScrollPosition: 0
    }
  },
  mounted() {
    this.$nextTick(() => {
      window.addEventListener('resize', throttle(this.closeMenu, 500))
      window.addEventListener('scroll', throttle(this.hideNav, 250))
    })
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.closeMenu)
    window.removeEventListener('scroll', this.hideNav)
  },
  methods: {
    closeMenu() {
      this.isActive = false
    },
    hideNav() {
      const currentScrollPosition =
        window.pageYOffset || document.documentElement.scrollTop
      if (currentScrollPosition < 0) return
      if (Math.abs(currentScrollPosition - this.lastScrollPosition) < 60) return
      this.showNavbar = currentScrollPosition < this.lastScrollPosition
      this.lastScrollPosition = currentScrollPosition
      setTimeout(this.closeMenu, 250)
    }
  }
}
</script>
