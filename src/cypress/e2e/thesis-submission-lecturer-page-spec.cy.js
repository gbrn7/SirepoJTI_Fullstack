describe('Cek fungsi halaman tugas akhir', () => {
  it('Cek perilaku sistem jika membuka halaman data tugas akhir bimbingan', () => {
    cy.logInLecturer('usmannurhasan', 'userpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-thesis-submission-lecturer"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-submission-lecturer')
    })
  })

  it('Cek perilaku sistem jika menyaring data tugas akhir bimbingan', () => {
    cy.logInLecturer('usmannurhasan', 'userpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-thesis-submission-lecturer"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-submission-lecturer')
    })

    cy.get('[data-cy="input-title"]').type('Sistem Informasi-1')
    cy.get('[data-cy="input-username"]').type('bagustejo')
    cy.get('[data-cy="input-student-class-year"]').type('2021')
    cy.get('[data-cy="select-program-study"]').type('3')
    cy.get('[data-cy="select-submission-status"]').type('accepted')
    cy.get('[data-cy="btn-submit"]').click()

    cy.contains('tr', 'Sistem Informasi-1').should('exist');
  })

})