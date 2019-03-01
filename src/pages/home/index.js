const router = require('koa-router')()
const admin = require('firebase-admin')

router.get('/', async (ctx) => {
  const projects = []
  const projectTypeIndicator = {
    app: ['smartphone', '#00c853'],
    game: ['videogame_asset', '#b71c1c'],
    web: ['web', '#00b0ff'],
    watch: ['watch', '#8e24aa'],
    other: ['code', '#ff9100']
  }

  let snapshot
  try {
    snapshot = await admin.firestore().collection('projects').orderBy('importance', 'desc').get()
    snapshot.forEach(doc => {
      const data = doc.data()
      projects.push({
        date: data.date,
        description: data.description,
        id: data.id,
        images: data.images,
        links: data.links,
        tags: [['Android', '#6200ea'], ['Kotlin', '#64dd17'], ['android', '#6200ea']],//todo: do
        title: data.title,
        type: projectTypeIndicator[data.type],
      })
    })
    projects.forEach(item => {
      console.log('images:', item.images)
    })

    await ctx.render('home.njk', { projects })
  } catch (e) {
    // todo do
  }

})

module.exports = router.routes()