using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Mvc;
using calculateMWT.Models;

namespace calculateMWT.Controllers
{
    public class HomeController : Controller
    {
        private CalculateMWTEntities db = new CalculateMWTEntities();

        // GET: Game
        public ActionResult Index(string id)
        {
            string searchString = id;

            var game = from m in db.GameInfoes
                       select m;

            if (!String.IsNullOrEmpty(searchString))
            {
                game = game.Where(s => s.name.Contains(searchString));
            }

            return View(db.GameInfoes.ToList());
        }

        // GET: Game/Details/5
        public ActionResult Details(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            GameInfo gameInfo = db.GameInfoes.Find(id);
            if (gameInfo == null)
            {
                return HttpNotFound();
            }
            return View(gameInfo);
        }

        // GET: Game/Create
        public ActionResult Create()
        {
            return View();
        }

        // POST: Game/Create
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create([Bind(Include = "id,name,developer,hours,info")] GameInfo gameInfo)
        {
            if (ModelState.IsValid)
            {
                db.GameInfoes.Add(gameInfo);
                db.SaveChanges();
                return RedirectToAction("Index");
            }

            return View(gameInfo);
        }

        // GET: Game/Edit/5
        public ActionResult Edit(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            GameInfo gameInfo = db.GameInfoes.Find(id);
            if (gameInfo == null)
            {
                return HttpNotFound();
            }
            return View(gameInfo);
        }

        // POST: Game/Edit/5
        // To protect from overposting attacks, please enable the specific properties you want to bind to, for 
        // more details see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit([Bind(Include = "id,name,developer,hours,info")] GameInfo gameInfo)
        {
            if (ModelState.IsValid)
            {
                db.Entry(gameInfo).State = EntityState.Modified;
                db.SaveChanges();
                return RedirectToAction("Index");
            }
            return View(gameInfo);
        }

        // GET: Game/Delete/5
        public ActionResult Delete(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            GameInfo gameInfo = db.GameInfoes.Find(id);
            if (gameInfo == null)
            {
                return HttpNotFound();
            }
            return View(gameInfo);
        }

        // POST: Game/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteConfirmed(int id)
        {
            GameInfo gameInfo = db.GameInfoes.Find(id);
            db.GameInfoes.Remove(gameInfo);
            db.SaveChanges();
            return RedirectToAction("Index");
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                db.Dispose();
            }
            base.Dispose(disposing);
        }
    }
}
