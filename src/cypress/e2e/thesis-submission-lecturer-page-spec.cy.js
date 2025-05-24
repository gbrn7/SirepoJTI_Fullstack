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
    cy.get('[data-cy="select-program-study"]').select('3')
    cy.get('[data-cy="select-submission-status"]').select('accepted')
    cy.get('[data-cy="btn-submit"]').click()

    cy.contains('tr', 'Sistem Informasi-1').should('exist');
  })

  it('Cek perilaku sistem saat ekspor data excel', () => {
    cy.logInLecturer('usmannurhasan', 'userpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-thesis-submission-lecturer"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-submission-lecturer')
    })

    cy.get('[data-cy="btn-modal-export"]').click();
    cy.get('[data-cy="select-format-export-type"]').select('excel')
    cy.get('[data-cy="btn-export-submit"]').click();
  })

  it('Cek perilaku sistem saat ekspor data pdf', () => {
    cy.logInLecturer('usmannurhasan', 'userpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-thesis-submission-lecturer"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/thesis-submission-lecturer')
    })

    cy.get('[data-cy="btn-modal-export"]').click();
    cy.get('[data-cy="select-format-export-type"]').select('pdf')
    cy.get('[data-cy="btn-export-submit"]').click();
  })

})