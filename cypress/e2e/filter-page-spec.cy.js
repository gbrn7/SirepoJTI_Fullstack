
describe('template spec', () => {
  it('Cek perilaku sistem jika menyaring data berdasarkan tahun publikasi', () => {
    cy.visit('/')

    cy.get('[data-cy="filter-box-publication-year"]').click();
    cy.location().should((loc) => {
      expect(loc.toString()).to.eq(
        Cypress.config().baseUrl + '/filter/year'
      )
    })

    cy.get('[data-cy="link-filter"]').contains("2025").click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/home')
      expect(loc.search).to.eq('?publication_from=2025&publication_until=2025')
      expect(loc.toString()).to.eq(
        Cypress.config().baseUrl + '/home?publication_from=2025&publication_until=2025'
      )
    })

    cy.get('[data-cy="input-publication-from"]').should('have.value', '2025');
    cy.get('[data-cy="input-publication-until"]').should('have.value', '2025');
  })

  it('Cek perilaku sistem jika menyaring data berdasarkan program studi', () => {
    cy.visit('/')

    cy.get('[data-cy="filter-box-program-study"]').click();
    cy.location().should((loc) => {
      expect(loc.toString()).to.eq(
        Cypress.config().baseUrl + '/filter/program-study'
      )
    })

    const prody = "D4 Sistem Informasi Bisnis"

    cy.get('[data-cy="link-filter"]').contains(prody).click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/home')
      expect(loc.search).to.eq('?program_study_id=3')
      expect(loc.toString()).to.eq(
        Cypress.config().baseUrl + '/home?program_study_id=3'
      )
    })

    cy.get('[data-cy="prody-checkbox-wrapper"]').contains(prody).prev().should('be.checked');
  })

  it('Cek perilaku sistem jika menyaring data berdasarkan topik tugas akhir', () => {
    cy.visit('/')

    cy.get('[data-cy="filter-box-topic"]').click();
    cy.location().should((loc) => {
      expect(loc.toString()).to.eq(
        Cypress.config().baseUrl + '/filter/topic'
      )
    })

    const topic = "Data"

    cy.get('[data-cy="link-filter"]').contains(topic).click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/home')
      expect(loc.search).to.eq('?topic_id=3')
      expect(loc.toString()).to.eq(
        Cypress.config().baseUrl + '/home?topic_id=3'
      )
    })

    cy.get('[data-cy="topic-checkbox-wrapper"]').contains(topic).prev().should('be.checked');
  })

  it('Cek perilaku sistem jika menyaring data berdasarkan penulis', () => {
    cy.visit('/')

    cy.get('[data-cy="filter-box-author"]').click();
    cy.location().should((loc) => {
      expect(loc.toString()).to.eq(
        Cypress.config().baseUrl + '/filter/author'
      )
    })

    const author = "Asyam, Farhan"

    cy.get('[data-cy="link-filter"]').contains(author).click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/home')
      expect(loc.search).to.eq('?student_id=2')
      expect(loc.toString()).to.eq(
        Cypress.config().baseUrl + '/home?student_id=2'
      )
    })
  })

  it('Cek perilaku sistem jika menyaring data berdasarkan jenis tugas akhir', () => {
    cy.visit('/')

    cy.get('[data-cy="filter-box-thesis-type"]').click();
    cy.location().should((loc) => {
      expect(loc.toString()).to.eq(
        Cypress.config().baseUrl + '/filter/thesis-type'
      )
    })

    const type = "Skripsi"

    cy.get('[data-cy="link-filter"]').contains(type).click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/home')
      expect(loc.search).to.eq('?type_id=2')
      expect(loc.toString()).to.eq(
        Cypress.config().baseUrl + '/home?type_id=2'
      )
    })

    cy.get('[data-cy="thesis-type-checkbox-wrapper"]').contains(type).prev().should('be.checked');
  })
})