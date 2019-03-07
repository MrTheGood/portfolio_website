const router = require('koa-router')()
const admin = require('firebase-admin')

router.get('/', async (ctx) => {
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
        date: data.date || '',
        description: data.description,
        id: data.id,
        images: data.images || [],
        links: data.links || [],
        tags: (data.tags || []).map(getTagColor),
        title: data.title,
        type: projectTypeIndicator[data.type || 'other']
      })
    })

    await ctx.render('home.njk', { projects })
  } catch (e) {
    console.log('error', e)
    // todo do
  }

})

module.exports = router.routes()