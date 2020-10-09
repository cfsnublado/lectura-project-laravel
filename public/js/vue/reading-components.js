const UserSearch = {
  mixins: [
    BaseSearch
  ],
  methods: {
    setResult(result) {
      this.searchTerm = result
      this.isOpen = false
      if (this.searchOnSelect) {
        this.search()
      }
    },
    search() {
      clearTimeout(this.searchTimerId)
      url = this.searchUrl + "?username=" + encodeURIComponent(this.searchTerm)
      window.location.assign(url)
    }
  }
}

const Project = {
  mixins: [
    AdminMixin,
    MarkdownMixin
  ],
  props: {
    initProject: {
      type: Object,
      required: true
    },
    initViewUrl: {
      type: String,
      default: ''
    },
    initEditUrl: {
      type: String,
      default: ''
    },
    initDeleteUrl: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      project: this.initProject,
      viewUrl: this.initViewUrl,
      editUrl: this.initEditUrl,
      deleteUrl: this.initDeleteUrl,
      idPlaceholder: 0,
      slugPlaceholder: 'zzz'
    }
  },
  methods: {
    view() {
      if (this.viewUrl) {
        window.location.assign(this.viewUrl)
      }
    },
    edit() {
      if (this.editUrl) {
        window.location.assign(this.editUrl)
      }
    },
    remove() {
      this.$emit('delete-project', this.project.id)
    }
  },
  created() {
    if (this.initViewUrl) {
      this.viewUrl = this.initViewUrl
        .replace(this.slugPlaceholder, this.project.slug)   
    }

    if (this.initEditUrl) {
      this.editUrl = this.initEditUrl
        .replace(this.slugPlaceholder, this.project.slug)   
    }

    if (this.initDeleteUrl) {
      this.deleteUrl = this.initDeleteUrl
        .replace(this.idPlaceholder, this.project.id)
    }
  }
}

const Projects = {
  components: {
    'project': Project
  },
  mixins: [
    AdminMixin,
    AjaxProcessMixin,
    PaginationMixin
  ],
  props: {
    projectsUrl: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      projects: null,
      timerId: null,
      processDelay: 500
    }
  },
  methods: {
    getProjects(page=1) {
      clearTimeout(this.timerId)
      this.process()

      params = {
        page: page
      }

      this.timerId = setTimeout(()=>{
        axios.get(this.projectsUrl, {
          params: params
        })
        .then(response => {
          this.projects = response.data.data
          this.setPagination(
            response.links.prev,
            response.links.next,
            response.meta.current_page,
            response.meta.total,
            response.meta.last_page
          )
          VueScrollTo.scrollTo({
            el: '#projects-scroll-top',
          })
          this.success()
        })
        .catch(error => {
          if (error.response) {
            console.log(error.response)
          } else if (error.request) {
            console.log(error.request)
          } else {
            console.log(error.message)
          }
          console.log(error.config)
        })
        .finally(() => {
          this.complete()
        })
      }, this.processDelay)
    },
    deleteProject(index) {
      this.$delete(this.projects, index)
    }
  },
  created() {
    this.getProjects()
  }
}

const ProjectMember = {
  mixins: [
    AdminMixin,
    VisibleMixin
  ],
  props: {
    initProjectMember: {
      type: Object,
      required: true
    },
    initViewUrl: {
      type: String,
      default: ''
    },
    initEditUrl: {
      type: String,
      default: ''
    },
    initDeleteUrl: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      projectMember: this.initProjectMember,
      viewUrl: this.initViewUrl,
      editUrl: this.initEditUrl,
      deleteUrl: this.initDeleteUrl,
      idPlaceholder: '0',
      slugPlaceholder: 'zzz'
    }
  },
  methods: {
    view() {
      if (this.viewUrl) {
        window.location.assign(this.viewUrl)
      }
    },
    edit() {
      if (this.editUrl) {
        window.location.assign(this.editUrl)
      }
    },
    remove() {
      this.$emit('delete-project-member', this.projectMember.id)
      console.log(this.projectMember.id)
      console.log('delete project member')
    }
  },
  created() {
    if (this.initViewUrl) {
      this.viewUrl = this.initViewUrl
        .replace(this.idPlaceholder, this.projectMember.id)
    }

    if (this.initEditUrl) {
      this.editUrl = this.initEditUrl
        .replace(this.idPlaceholder, this.projectMember.id)
    }

    if (this.initDeleteUrl) {
      this.deleteUrl = this.initDeleteUrl
        .replace(this.idPlaceholder, this.projectMember.id)
    }
  }
}

const ProjectMembers = {
  components: {
    'project-member': ProjectMember
  },
  mixins: [
    AdminMixin,
    AjaxProcessMixin,
    PaginationMixin
  ],
  props: {
    projectMembersUrl: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      projectMembers: null
    }
  },
  methods: {
    getProjectMembers(page=1) {
      this.process()

      params = {
        page: page
      }

      axios.get(this.projectMembersUrl, {
        params: params
      })
      .then(response => {
        this.projectMembers = response.data.results
        this.setPagination(
          response.data.previous,
          response.data.next,
          response.data.page_num,
          response.data.count,
          response.data.num_pages
        )
        VueScrollTo.scrollTo({
          el: '#project-members-scroll-top',
        })
        this.success()
      })
      .catch(error => {
        if (error.response) {
          console.log(error.response)
        } else if (error.request) {
          console.log(error.request)
        } else {
          console.log(error.message)
        }
        console.log(error.config)
      })
      .finally(() => {
        this.complete()
      })
    },
    deleteProjectMember(index) {
      this.$delete(this.projectMembers, index)
    }
  },
  created() {
    this.getProjectMembers()
  }
}


const Post = {
  mixins: [
    AdminMixin,
    MarkdownMixin
  ],
  props: {
    initPost: {
      type: Object,
      required: true
    },
    initViewUrl: {
      type: String,
      default: ''
    },
    initEditUrl: {
      type: String,
      default: ''
    },
    initDeleteUrl: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      post: this.initPost,
      viewUrl: this.initViewUrl,
      editUrl: this.initEditUrl,
      deleteUrl: this.initDeleteUrl,
      idPlaceholder: '0',
      slugPlaceholder: 'zzz'
    }
  },
  methods: {
    view() {
      if (this.viewUrl) {
        window.location.assign(this.viewUrl)
      }
    },
    edit() {
      if (this.editUrl) {
        window.location.assign(this.editUrl)
      }      
    },
    remove() {
      this.$emit('delete-post', this.post.id)
    }
  },
  created() {
    if (this.initViewUrl) {
      this.viewUrl = this.initViewUrl
        .replace(this.slugPlaceholder, this.post.slug)
    }

    if (this.initEditUrl) {
      this.editUrl = this.initEditUrl
        .replace(this.slugPlaceholder, this.post.slug)
    }

    if (this.initDeleteUrl) {
      this.deleteUrl = this.initDeleteUrl
        .replace(this.idPlaceholder, this.post.id)
    }
  }
}

const Posts = {
  components: {
    'post': Post
  },
  mixins: [
    AdminMixin,
    AjaxProcessMixin,
    PaginationMixin
  ],
  props: {
    postsUrl: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      posts: null,
      timerId: null,
      processDelay: 500,
    }
  },
  methods: {
    getPosts(page=1) {
      clearTimeout(this.timerId)
      this.process()

      params = {
        page: page
      }

      this.timerId = setTimeout(()=>{
        axios.get(this.postsUrl, {
          params: params
        })
        .then(response => {
          this.posts = response.data.data
          this.setPagination(
            response.links.prev,
            response.links.next,
            response.meta.current_page,
            response.meta.total,
            response.meta.last_page
          )
          VueScrollTo.scrollTo({
            el: '#posts-scroll-top',
          })
          this.success()
        })
        .catch(error => {
          if (error.response) {
            console.log(error.response)
          } else if (error.request) {
            console.log(error.request)
          } else {
            console.log(error.message)
          }
          console.log(error.config)
        })
        .finally(() => {
          this.complete()
        })
      }, this.processDelay)
    },
    deletePost(index) {
      this.$delete(this.posts, index)
    }
  },
  created() {
    this.getPosts()
  }
}

const PostAudio = {
  mixins: [
    AdminMixin,
    MarkdownMixin
  ],
  props: {
    initPostAudio: {
      type: Object,
      required: true
    },
    initViewUrl: {
      type: String,
      default: ''
    },
    initPostViewUrl: {
      type: String,
      default: ''
    },
    initEditUrl: {
      type: String,
      default: ''
    },
    initDeleteUrl: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      postAudio: this.initPostAudio,
      viewUrl: this.initViewUrl,
      editUrl: this.initEditUrl,
      deleteUrl: this.initDeleteUrl,
      postViewUrl: this.initPostViewUrl,
      idPlaceholder: 0,
      slugPlaceholder: 'zzz'
    }
  },
  methods: {
    edit() {
      if (this.editUrl) {
        window.location.assign(this.editUrl)
      }
    },
    remove() {
      this.$emit('delete-post-audio', this.postAudio.id)
    },
    viewPost() {
      if (this.viewPostUrl) {
        window.location.assign(this.viewPostUrl)
      }
    },
  },
  created() {
    if (this.initDeleteUrl) {
      this.deleteUrl = this.initDeleteUrl
        .replace(this.idPlaceholder, this.postAudio.id)
    }

    if (this.initEditUrl) {
      this.editUrl = this.initEditUrl
        .replace(this.idPlaceholder, this.postAudio.id)
    }

    if (this.initPostViewUrl) {
      this.postViewUrl = this.initPostViewUrl
        .replace(this.slugPlaceholder, this.postAudio.post_slug)
    }
  }
}

const PostAudios = {
  components: {
    'post-audio': PostAudio
  },
  mixins: [
    AdminMixin,
    AjaxProcessMixin,
    PaginationMixin
  ],
  props: {
    postAudiosUrl: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      postAudios: null,
      timerId: null,
      processDelay: 500
    }
  },
  methods: {
    getPostAudios(page=1) {
      clearTimeout(this.timerId)
      this.process()

      params = {
        page: page
      }

      this.timerId = setTimeout(()=>{
        axios.get(this.postAudiosUrl, {
          params: params
        })
        .then(response => {
          this.postAudios = response.data.data
          this.setPagination(
            response.links.prev,
            response.links.next,
            response.meta.current_page,
            response.meta.total,
            response.meta.last_page
          )
          VueScrollTo.scrollTo({
            el: '#post-audios-scroll-top',
          })
          this.success()
        })
        .catch(error => {
          if (error.response) {
            console.log(error.response)
          } else if (error.request) {
            console.log(error.request)
          } else {
            console.log(error.message)
          }
          console.log(error.config)
        })
        .finally(() => {
          this.complete()
        })
      }, this.processDelay)
    },
    deletePostAudio(index) {
      this.$delete(this.postAudios, index)
    }
  },
  created() {
    this.getPostAudios()
  }
}