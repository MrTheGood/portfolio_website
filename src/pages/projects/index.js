const router = require('koa-router')()
const admin = require('firebase-admin')

router.get('/:projectId', async (ctx) => {
  const { projectId } = ctx.params

  const projectTypeIndicator = {
    app: ['smartphone', '#00c853'],
    game: ['videogame_asset', '#b71c1c'],
    web: ['web', '#00b0ff'],
    watch: ['watch', '#8e24aa'],
    other: ['code', '#ff9100']
  }

  try {
    const doc = await admin.firestore().collection('projects').doc(projectId).get()
    const data = doc.data()

    if (doc) {
      await ctx.render('project.njk', {
        project: {
          date: data.date,
          description: data.description,
          id: data.id,
          images: data.images,
          links: data.links,
          tags: [['Android', '#6200ea'], ['Kotlin', '#64dd17'], ['android', '#6200ea']],//todo: do
          title: data.title,
          type: projectTypeIndicator[data.type],
        },
      })
    } else {
      //todo: reroute to home
    }
  } catch (e) {
    // todo: do
  }
})

module.exports = router.routes()