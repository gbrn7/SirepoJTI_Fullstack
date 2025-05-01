describe('Cek fungsi halaman dashboard', () => {
  it('Cek perilaku sistem saat membuka halaman dashboard', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-dashboard"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/dashboard')
    })
  })

  it('Cek perilaku sistem saat menyaring data', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-dashboard"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/dashboard')
    })

    cy.get('[data-cy="input-publication-year"]').type('2025')
    cy.get('[data-cy="input-class-year"]').type('2021')
    cy.get('[data-cy="select-program-study"]').select(3)
    cy.get('[data-cy="select-topic"]').select(2)
    cy.get('[data-cy="select-lecturer"]').select(1)
    cy.get('[data-cy="select-thesis-type"]').select(2)
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/dashboard')
    })
  })

  it('Cek perilaku sistem saat membuka halaman dashboard sebagai dosen', () => {
    cy.logInLecturer('usmannurhasan', 'userpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-dashboard"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/dashboard')
    })
  })

  it('Cek perilaku sistem saat menyaring data sebagai dosen', () => {
    cy.logInLecturer('usmannurhasan', 'userpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-dashboard"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/dashboard')
    })

    cy.get('[data-cy="input-publication-year"]').type('2025')
    cy.get('[data-cy="input-class-year"]').type('2021')
    cy.get('[data-cy="select-program-study"]').select(3)
    cy.get('[data-cy="select-topic"]').select(2)
    cy.get('[data-cy="select-lecturer"]').select(1)
    cy.get('[data-cy="select-thesis-type"]').select(2)
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/dashboard')
    })
  })
})