const router = require('koa-router')()
const admin = require('firebase-admin')

router.get('/:projectId', async (ctx) => {
  const { projectId } = ctx.params
  const tags = []
  const tagColors = [
    '#6200ea', '#64dd17', '#0091ea',
    '#4dd0e1', '#d500f9', '#f50057',
    '#00ff00', '#ffc400', '#ff9100'
  ]

  function getTagColor(tag) {
    tag = tag.charAt(0).toUpperCase() + tag.slice(1)

    if (!tags.includes(tag))
      tags.push(tag)
    const pos = tags.indexOf(tag) % tagColors.length

    return [tag, tagColors[pos]]
  }

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

    if (doc && data) {
      await ctx.render('project.njk', {
        project: {
          date: data.date || '',
          description: data.description,
          id: data.id,
          images: data.images,
          links: data.links || [],
          tags: (data.tags || []).map(getTagColor),
          title: data.title,
          type: projectTypeIndicator[data.type || 'other']
        }
      })
    } else {
      console.log('not found!', projectId)
      //todo: reroute to home
    }
  } catch (e) {
    console.log('error', e)
    // todo: do
  }
})

module.exports = router.routes()